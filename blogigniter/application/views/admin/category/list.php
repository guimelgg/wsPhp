<table class="table table-condensed">
    <tbody>
        <tr>
            <th style="width: 10px">#</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($categories as $key => $c) : ?>
            <tr>
                <td><?php echo $c->category_id ?></td>
                <td><?php echo $c->name ?></td>
                <td>
                    <a class="btn btn-sm btn-primary" 
                       href="<?php echo base_url() . 'admin/category_save/' . $c->category_id ?>">
                        <i class="fa fa-pencil"></i> Editar
                    </a>
                    <br>
                    <a class="btn btn-sm btn-danger" 
                       data-toggle="modal" 
                       data-target="#deleteModal"
                       href="#"
                       data-categoryid="<?php echo $c->category_id ?>">
                        <i class="fa fa-remove"></i> Eliminar
                    </a>
                </td>

            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="borrar-category" data-dismiss="modal">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<script>

    var category_id = 0;
    var buttondelete;

// abrir el modal
    $('#deleteModal').on('show.bs.modal', function (event) {
        buttondelete = $(event.relatedTarget) // Button that triggered the modal
        category_id = buttondelete.data('categoryid') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('Seguro que desea eliminar la Categoria seleccionada ' + category_id)
    });

// llamar a eliminar
    $("#borrar-category").click(function () {
        $.ajax({
            url: "<?php echo base_url() ?>admin/category_delete/" + category_id
        }).done(function (res) {
            if (res == 1) {
                $(buttondelete).parent().parent().remove();
            }
        });
    });
</script> 


