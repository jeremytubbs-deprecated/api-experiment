<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Type;

class TypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = new Type();
        $type->title = 'Post';
        $type->slug = 'Posts';
        $type->description = 'Create a blog post.';
        $type->save();

        $type = new Type();
        $type->title = 'Page';
        $type->slug = 'Pages';
        $type->description = 'Create a page.';
        $type->save();

        $type = new Type();
        $type->title = 'Project';
        $type->slug = 'Projects';
        $type->description = 'Create a project post.';
        $type->save();

        $type = new Type();
        $type->title = 'Product';
        $type->slug = 'Products';
        $type->description = 'Create a product';
        $type->save();

        $type = new Type();
        $type->title = 'Publication';
        $type->slug = 'Publications';
        $type->description = 'Create a book project.';
        $type->save();
    }
}
