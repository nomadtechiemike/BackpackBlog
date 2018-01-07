{{-- Show the inputs --}}
<?php $fieldCount = count($fields); $i = 0; ?>
@foreach ($fields as $field)
      <?php
        $i++;
        if($field['position'] !== $position) { continue; }

      ?>
      <!-- load the view from the application if it exists, otherwise load the one in the package -->
      @if(view()->exists('vendor.backpack.crud.fields.'.$field['type']))
          @include('vendor.backpack.crud.fields.'.$field['type'], array('field' => $field))
      @else
          @include('crud::fields.'.$field['type'], array('field' => $field))
      @endif
      @if($field['position'] == 'sidebar' && $i !== $fieldCount)
        <div class="clearfix"></div>
        <div class="box-header with-border" style="margin-bottom: 15px;padding-bottom: 0px;"></div>
      @endif
@endforeach
