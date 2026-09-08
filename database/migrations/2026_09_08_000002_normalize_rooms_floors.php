<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Floors of the building illustration. The rooms table no longer carries floor names or
     * outlines (2026_08_04 dropped them), so new floor rows take these; the outlines are
     * replaced with image-relative ones by 2026_09_08_000004.
     */
    private const DEFAULT_FLOORS = [
        'ground' => ['name' => 'Ground Floor', 'view' => 'Garden View', 'coords' => '135,792,852,792,852,917,135,917'],
        'first' => ['name' => 'First Floor', 'view' => 'Partial Ocean View', 'coords' => '135,656,855,656,855,775,135,775'],
        'second' => ['name' => 'Second Floor', 'view' => 'Ocean View', 'coords' => '135,501,854,501,854,635,135,635'],
        'third' => ['name' => 'Third Floor', 'view' => 'Panoramic Ocean View', 'coords' => '126,352,852,352,852,471,126,471'],
    ];

    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->renameColumn('floor_id', 'floor_slug');
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->renameColumn('order', 'sort_order');
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->unsignedBigInteger('floor_id')->nullable()->after('id');
            $table->index('floor_id');
            // Dropped by 2026_07_17; the admin and the homepage identify rooms by number again.
            $table->integer('room_number')->nullable()->after('floor_id');
            $table->string('room_name')->nullable()->after('room_number');
        });

        $this->backfillFloors();
        $this->backfillRoomNumbers();

        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn(['floor_slug', 'floor_view']);
        });

        // SQLite cannot add constraints to an existing table; tests run on SQLite.
        if (DB::getDriverName() !== 'sqlite') {
            Schema::table('rooms', function (Blueprint $table) {
                $table->unsignedBigInteger('floor_id')->nullable(false)->change();
                $table->foreign('floor_id')->references('id')->on('floors')->restrictOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            Schema::table('rooms', function (Blueprint $table) {
                $table->dropForeign(['floor_id']);
            });
        }

        Schema::table('rooms', function (Blueprint $table) {
            $table->string('floor_slug')->default('');
            $table->string('floor_view')->default('');
        });

        foreach (DB::table('floors')->get() as $floor) {
            DB::table('rooms')->where('floor_id', $floor->id)->update([
                'floor_slug' => $floor->slug,
                'floor_view' => $floor->view,
            ]);
        }

        Schema::table('rooms', function (Blueprint $table) {
            $table->dropIndex(['floor_id']);
            $table->dropColumn(['floor_id', 'room_number', 'room_name']);
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->renameColumn('floor_slug', 'floor_id');
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->renameColumn('sort_order', 'order');
        });
    }

    private function backfillFloors(): void
    {
        $now = now();
        $knownSlugs = array_keys(self::DEFAULT_FLOORS);
        $nextSort = max(count($knownSlugs) - 1, (int) DB::table('floors')->max('sort_order'));

        foreach (DB::table('rooms')->distinct()->pluck('floor_slug') as $slug) {
            $slug = (string) $slug;
            $floorId = DB::table('floors')->where('slug', $slug)->value('id');

            if (! $floorId) {
                $view = DB::table('rooms')->where('floor_slug', $slug)->where('floor_view', '!=', '')->orderBy('sort_order')->value('floor_view');
                $default = self::DEFAULT_FLOORS[$slug] ?? null;
                $knownIndex = array_search($slug, $knownSlugs, true);

                $floorId = DB::table('floors')->insertGetId([
                    'slug' => $slug,
                    'name' => $default['name'] ?? ucfirst($slug).' Floor',
                    'view' => $view ?: ($default['view'] ?? ''),
                    'coords' => $default['coords'] ?? '',
                    'sort_order' => $knownIndex === false ? ++$nextSort : $knownIndex,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            DB::table('rooms')->where('floor_slug', $slug)->update(['floor_id' => $floorId]);
        }
    }

    /**
     * Rooms created while numbers were gone get one per floor (101, 102, ... 201, ...) and a
     * name from their type, both editable in the admin.
     */
    private function backfillRoomNumbers(): void
    {
        foreach (DB::table('floors')->orderBy('sort_order')->orderBy('id')->get() as $floor) {
            $rooms = DB::table('rooms')->where('floor_id', $floor->id)->whereNull('room_number')->orderBy('sort_order')->orderBy('id')->get();

            foreach ($rooms->values() as $position => $room) {
                $type = trim((string) ($room->room_type ?? ''));
                DB::table('rooms')->where('id', $room->id)->update([
                    'room_number' => ($floor->sort_order + 1) * 100 + $position + 1,
                    'room_name' => $type !== '' ? ucfirst($type).' Room' : 'Room '.$room->id,
                ]);
            }
        }
    }
};
