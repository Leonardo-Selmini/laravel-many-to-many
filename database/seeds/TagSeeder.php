<?php

use App\Tag;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $tags = ["Lactose-Free", "Gluten-Free", "Vegetarian", "Vegan", "Light"];

      foreach ($tags as $tag) {
        $newTag = new Tag;
        $newTag -> name = $tag;
        $slug = Str::of($newTag->name)->slug("-");
        $counter = 1;
        while(Tag::where("slug", $slug)->first()) {
          $slug .= "-$counter";
          $counter++;
        }
        $newTag ->slug = $slug;
        $newTag -> save();
      }
    }
}
