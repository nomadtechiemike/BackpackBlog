<?php namespace AbbyJanke\Blog\app\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

use AbbyJanke\Blog\app\Http\Requests\Admin\TagCrudRequest as StoreRequest;
use AbbyJanke\Blog\app\Http\Requests\Admin\TagCrudRequest as UpdateRequest;

class TagCrudController extends CrudController
{
    public function setup()
    {
        $this->crud->setModel('AbbyJanke\Blog\app\Models\Tag');
        $this->crud->setRoute(config('backpack.base.route_prefix')  . '/blog/tag');
        $this->crud->setEntityNameStrings('tag', 'tags');

        $this->crud->denyAccess('show');

        $this->crud->setFromDb();
    }

    public function store(StoreRequest $request)
    {
        return parent::storeCrud();
    }

    public function update(UpdateRequest $request)
    {
        return parent::updateCrud();
    }
		
    public function quickSave(StoreRequest $request)
    {
        $this->crud->hasAccessOrFail('create');

        // fallback to global request instance
        if (is_null($request)) {
            $request = \Request::instance();
        }

        // replace empty values with NULL, so that it will work with MySQL strict mode on
        foreach ($request->input() as $key => $value) {
            if (empty($value) && $value !== '0') {
                $request->request->set($key, null);
            }
        }

        // insert item in the db
        $item = $this->crud->create($request->except(['save_action', '_token', '_method']));

        return response()->json($item);
    }
}
