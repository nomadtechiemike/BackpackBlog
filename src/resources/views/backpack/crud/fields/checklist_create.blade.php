<!-- select2 -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label> <a class="btn btn-xs btn-success pull-right" data-toggle="modal" data-target="#newEntry{{ $field['name'] }}">{{ trans('backpack::crud.add').' '.$field['label'] }}</a>
    @include('crud::inc.field_translatable_icon')
    <?php $entity_model = $crud->getModel(); ?>

        <div id="cblist{{ $field['name'] }}" style="max-height: 150px;overflow:scroll;border:1px solid #f2f2f2;background: #f9f9f9">
        @foreach ($field['model']::all() as $connected_entity_entry)
            <div class="col-sm-12">
                <div class="checkbox">
                  <label>
                    <input type="checkbox"
                      name="{{ $field['name'] }}[]"
                      value="{{ $connected_entity_entry->getKey() }}"

                      @if( ( old( $field["name"] ) && in_array($connected_entity_entry->getKey(), old( $field["name"])) ) || (isset($field['value']) && in_array($connected_entity_entry->getKey(), $field['value']->pluck($connected_entity_entry->getKeyName(), $connected_entity_entry->getKeyName())->toArray())))
                             checked = "checked"
                      @endif > {!! $connected_entity_entry->{$field['attribute']} !!}
                  </label>
                </div>
            </div>
        @endforeach
      </div>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>

<div class="modal fade" id="newEntry{{ $field['name'] }}" tabindex="-1" role="dialog" aria-labelledby="newEntryLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">{{ trans('backpack::crud.add').' '.$field['label'] }}</h4>
      </div>
      <div class="modal-body">
        <input type="text" class="form-control" placeholder="{{ $field['label'] }}" id="newEntityName{{ $field['name'] }}" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="button" class="btn btn-primary" id="saveNewEntity{{ $field['name'] }}" value="{{ trans('backpack::crud.save') }} {!! $field['label'] !!}" />
      </div>
    </div>
  </div>
</div>

{{-- FIELD EXTRA JS --}}
{{-- push things in the after_scripts section --}}
@push('crud_fields_scripts')
  <script type="text/javascript">
  $(document).ready(function() {
    $('#saveNewEntity{{ $field['name'] }}').click(function() {
        $('#newEntry{{ $field['name'] }}').modal('hide');
        var cbList = $('#cblist{{ $field['name'] }}');
        $.ajax({
          url: '{{ backpack_url($field['route']) }}/create_quick',
          type: 'POST',
          // dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
          data: {name: $('#newEntityName{{ $field['name'] }}').val()},
        })
        .done(function(data) {
          cbList.append('<div class="col-sm-12"><div class="checkbox"><label><input type="checkbox" name="{{ $field["name"] }}" value="' + data.id + '" checked="checked"/> ' + data.name + '</label></div></div>');
          var height = cbList[0].scrollHeight;
          cbList.scrollTop(height);
        })
        .fail(function(data) {
          alert('Failed To Create New {{ $field['label'] }}');
          //console.log(data);
        })

      });
  });

</script>
@endpush
