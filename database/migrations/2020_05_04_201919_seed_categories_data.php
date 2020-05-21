
<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class SeedCategoriesData extends Migration
{
    public function up()
    {
        $categories = [
            [
            'column_name' => '娱乐'
            ],
            [
            'column_name' => '音乐'
            ],
            [
            'column_name' => '舞蹈'
            ],
            [
            'column_name' => '生活'
            ],
            [
            'column_name' => '科技'
            ],
            [
            'column_name' => 'VLOG'
            ],
            [
            'column_name' => '鬼畜'
            ],
            [
            'column_name' => '游戏'
            ],
            [
            'column_name' => '番剧'
            ],
            [
            'column_name' => '影视'
            ],
            ];
        DB::table('categories')->insert($categories);
    }
    public function down()
    {
        DB::table('categories')->truncate(); }
}
