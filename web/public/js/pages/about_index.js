/**
 * Created by Cesar Augusto on 16/02/2016.
 */

function click() {
    swal({
        title: "Tem Certeza?",
        text: "você esta prestes a inativar um titulo.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Sim, Inativar!",
        closeOnConfirm: false
    }, function () {
        swal("Inativado!", "Este titulo foi inativado.", "success");
    });
}

$(document).ready(function () {
    $('#btn-action').click(click);
});