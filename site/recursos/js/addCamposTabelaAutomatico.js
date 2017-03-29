    (function ($) {

        RemoveTableRow = function (handler) {
            var tr = $(handler).closest('tr');

            tr.fadeOut(400, function () {
                tr.remove();
            });

            return false;
        };

        AddTableRow = function () {


            var newRow = $("<tr>");
            var cols = "";
            var numeroContratoAluguel = $("#numeroProcessoAluguel").val();
            var dataInicialContrato = $("#dataInicialProcessoAluguel").val();
            var dataFinalContrato = $("#dataFinalProcessoAluguel").val();


            cols += '<td>     <input type="text" class="form-control" name ="numeroProcessoAluguel[]"  required="true" value="' + numeroContratoAluguel + '" maxlength="11" placeholder="000000" readonly="true"/></td>';
            cols += '<td>     <input type="text" class="form-control" name ="dataInicialProcessoAluguel[]" required="true" value="' + dataInicialContrato + '" maxlength="12" placeholder="00/00/0000" readonly="true"/></td>';
            cols += '<td>     <input type="text" class="form-control" name ="dataFinalProcessoAluguel[]"  required="true" value="' + dataFinalContrato + '" maxlength="12" placeholder="00/00/0000" readonly="true"/></td>';

            cols += '<td class="actions">';
            cols += '<button class="btn btn-large btn-danger" onclick="RemoveTableRow(this)" type="button">Remover</button>';
            cols += '</td>';

            newRow.append(cols);

            $("#tabela-contrato").append(newRow);

            //zero campos
            $("#numeroProcessoAluguel").val("");
            $("#dataInicialProcessoAluguel").val("");
            $("#dataFinalProcessoAluguel").val("");

            return false;


        };

    })(jQuery);
