<?php namespace AbbyJanke\Blog\app\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

use AbbyJanke\Blog\app\Http\Requests\Admin\TagCrudRequest as StoreRequest;
use AbbyJanke\Blog\app\Http\Requests\Admin\TagCrudRequest as UpdateRequest;

class TagCrudController extends CrudController {

	public function setup() {
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
}
