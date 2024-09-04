<div class="btn-group">
    <a href="javascript:void(0)" class="btn btn-sm btn-primary mr-1" onclick="editCourse({{ $row->id }})">
        <i class="fa fa-edit"></i> Edit
    </a>

    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $row->id }})">
        <i class="fa fa-trash"></i> Delete
    </button>
</div>




