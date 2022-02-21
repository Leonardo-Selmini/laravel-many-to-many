<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\Post;

class PostsTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run(Faker $faker)
  {
    for($i = 0; $i < 20; $i++){
      $newPost = new Post;
      $newPost->title = $faker->word(6, true);

      $slug = Str::of($newPost->title)->slug("-");
      $counter = 1;
      while(Post::where("slug", $slug)->first()) {
        $slug .= "-$counter";
        $counter++;
      }
      $newPost->slug = $slug;

      $newPost->content = $faker->text();
      $newPost->posted = rand(0, 1);
      $newPost->save();
    }
  }
}
