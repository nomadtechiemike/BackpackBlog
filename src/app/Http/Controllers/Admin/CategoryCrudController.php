<?php namespace Backpack\Blog\app\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

use Backpack\Blog\app\Http\Requests\Admin\CategoryCrudRequest as StoreRequest;
use Backpack\Blog\app\Http\Requests\Admin\CategoryCrudRequest as UpdateRequest;

class CategoryCrudController extends CrudController {

	public function setup() {
		$this->crud->setModel('Backpack\Blog\app\Models\Category');
    $this->crud->setRoute(config('backpack.base.route_prefix')  . '/blog/category');
    $this->crud->setEntityNameStrings('category', 'categories');

    $this->crud->setFromDb();

		$this->crud->removeColumn('parent_id');
    $this->crud->addColumn([
			'label' => 'Parent Category',
			'type' => 'select',
			'name' => 'parent_id',
			'entity' => 'parent',
			'attribute' => 'name',
			'model' => "Backpack\Blog\app\Models\Category" // foreign key model
		]);

		$this->crud->removeField('parent_id');
		$this->crud->addField([
			'label' => "Parent Category",
			'type' => 'select',
			'name' => 'parent_id',
			'entity' => 'parent',
			'attribute' => 'name',
			'model' => "Backpack\Blog\app\Models\Category"
		]);
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
