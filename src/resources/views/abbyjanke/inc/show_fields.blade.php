{{-- Show the inputs --}}
@foreach ($fields as $field)
    @if($field['position'] == $position)
      <!-- load the view from the application if it exists, otherwise load the one in the package -->
      @if(view()->exists('vendor.backpack.crud.fields.'.$field['type']))
          @include('vendor.backpack.crud.fields.'.$field['type'], array('field' => $field))
      @else
          @include('crud::fields.'.$field['type'], array('field' => $field))
      @endif
    @endif
    @if($field['position'] == 'sidebar')
    <div class="box-header with-border" style="padding-bottom:0;margin-bottom:10px;"></div>
  @endif
@endforeach
