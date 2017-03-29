<div class="col-sm-12 col-md-offset-0 col-sm-12 col-sm-offset-0">
    <div style='max-height: 150px; overflow: auto;'>
        <table id="tabela-contrato" class="table-responsive">
            <thead>
                <tr>
                    <td>N° Processo:</td>
                    <td>Data Final:</td>
                    <td>Data Inicial:</td>
                    <td>Ações</td>
                </tr>
                <tr>
                    <th>    
                        <input type="text" class="form-control" name ="numeroProcessoAluguel[]" id="numeroProcessoAluguel"  value="" maxlength="6" placeholder="000000" onkeypress='return SomenteNumero(event)'/>
                    </th>
                    <th>    
                        <input type="text" class="form-control" name ="dataInicialProcessoAluguel[]" id="dataInicialProcessoAluguel"  value="" maxlength="12" placeholder="000000"  OnKeyUp='return mascaraData(this)'/>
                    </th>
                    <th>   
                        <input type="text" class="form-control" name ="dataFinalProcessoAluguel[]" id="dataFinalProcessoAluguel"  value="" maxlength="12" placeholder="000000"  OnKeyUp='return mascaraData(this)'/>
                    </th>
                    <th>  
                        <button onclick="AddTableRow()" type="button" class="btn btn-large btn-success">Adicionar</button>
                    </th>
                </tr>
            </thead>
            <tbody> 
                <!-- será preenchido quando o botão adicionar foir clicado -->
            </tbody>
        </table>
    </div>
</div>