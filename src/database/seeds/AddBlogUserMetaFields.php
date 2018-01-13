<?php

namespace AbbyJanke\Blog\Database\Seeds;

use Illuminate\Database\Seeder;
use AbbyJanke\BackpackMeta\app\Http\Models\Values as MetaField;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class AddBlogUserMetaFields extends Seeder
{
    public function run()
    {
        $field = new MetaField;
        $field->key = 'biography';
        $field->display = 'Biography';
        $field->type = 'textarea';
        $field->model = 'App\User';
        $field->save();

        $field = new MetaField;
        $field->key = 'url';
        $field->display = 'Website';
        $field->type = 'text';
        $field->model = 'App\User';
        $field->save();
    }
}
