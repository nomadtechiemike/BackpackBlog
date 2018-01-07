<?php namespace AbbyJanke\Blog\app\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

use AbbyJanke\Blog\app\Http\Requests\Admin\CategoryCrudRequest as StoreRequest;
use AbbyJanke\Blog\app\Http\Requests\Admin\CategoryCrudRequest as UpdateRequest;

class CategoryCrudController extends CrudController {

	public function setup() {
		$this->crud->setModel('AbbyJanke\Blog\app\Models\Category');
    $this->crud->setRoute(config('backpack.base.route_prefix')  . '/blog/category');
    $this->crud->setEntityNameStrings('category', 'categories');

    $this->crud->setFromDb();
		$this->crud->allowAccess('show');

		$this->crud->removeColumn('parent_id');
    $this->crud->addColumn([
			'name' => "parent_id",
			'label' => "Parent ID",
			'type' => "model_function",
			'function_name' => 'parent_name',
			'attribute' => 'name'
		]);

		$this->crud->removeField('parent_id');
		$this->crud->addField([
			'label' => "Parent Category",
			'type' => 'select',
			'name' => 'parent_id',
			'entity' => 'parent',
			'attribute' => 'name',
			'model' => "AbbyJanke\Blog\app\Models\Category"
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
