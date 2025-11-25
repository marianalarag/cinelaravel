<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Showtime;
use App\Models\Movie;
use App\Models\Room;
use Carbon\Carbon;

class ShowtimeSeeder extends Seeder
{
    public function run()
    {
        $movies = Movie::where('is_active', true)->get();
        $rooms = Room::where('is_active', true)->get();

        $startTimes = ['10:00', '13:00', '16:00', '19:00', '22:00'];
        $formats = ['2D', '3D', 'IMAX', '4DX'];
        $languages = ['Español', 'Subtitulada', 'Inglés'];

        foreach ($movies as $movie) {
            foreach ($rooms as $room) {
                foreach ($startTimes as $startTime) {
                    $start = Carbon::today()->addDays(rand(1, 7))->setTimeFromTimeString($startTime);
                    $end = $start->copy()->addMinutes($movie->duration + 30);

                    Showtime::updateOrCreate([
                        'movie_id' => $movie->id,
                        'room_id' => $room->id,
                        'start_time' => $start,
                    ], [
                        'end_time' => $end,
                        'price' => $this->getPriceByRoomType($room->type),
                        'available_seats' => $room->capacity,
                        'format' => $this->getFormatByRoomType($room->type),
                        'language' => $languages[array_rand($languages)],
                        'is_active' => true
                    ]);
                }
            }
        }
    }

    private function getPriceByRoomType($type)
    {
        return match($type) {
            'imax' => rand(15, 20),
            '4dx' => rand(18, 25),
            default => rand(8, 12), // standard
        };
    }

    private function getFormatByRoomType($type)
    {
        return match($type) {
            'imax' => 'IMAX',
            '4dx' => '4DX',
            default => ['2D', '3D'][array_rand(['2D', '3D'])],
        };
    }
}
