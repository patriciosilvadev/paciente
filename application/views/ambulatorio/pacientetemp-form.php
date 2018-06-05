<div class="content ficha_ceatox"> <!-- Inicio da DIV content -->
    <div class="clear"></div>
    <form name="form_exametemp" id="form_exametemp" action="<?= base_url() ?>ambulatorio/exametemp/gravarpaciente" method="post">
        </fieldset>
        <fieldset>
            <div>
                <label>Data</label>
                <input type="text"  id="data_ficha" name="data_ficha" class="size1"  />
                <input type="hidden" name="txtpaciente_id"  value="<?= @$obj->_ambulatorio_pacientetemp_id; ?>" />
            </div>
            <legend>Manter Exames</legend>

            <div>
                <label>Exame</label>
                <select name="exame" id="exame" class="size1">
                    <option value="" >Selecione</option>
                    <option value="RX" >RX</option>
                    <option value="TOMOGRAFIA" >TOMOGRAFIA</option>
                    <option value="RM" >RM</option>
                    <option value="ULTRA SOM" >ULTRA SOM</option>
                    <option value="MAMO" >MX/D.O</option>
                    <option value="ECG" >ECG</option>
                    <option value="ECOCARDIOGRAMA" >ECOCARDIOGRAMA</option>
                    <option value="ECOESPIROMETRIA" >ECOESPIROMETRIA</option>
                    <option value="ERGOMETRIA" >ERGOMETRIA</option>
                    <option value="ESPIROMETRIA" >ESPIROMETRIA</option>
                    <option value="HOLTER" >HOLTER</option>
                    <option value="MAPA" >MAPA</option>
                </select>
            </div>

            <div>
                <label>Horarios</label>
                <select name="horarios" id="horarios" class="size2">
                    <option value="" >-- Escolha um exame --</option>
                </select>
            </div>
            <div>
                <label>Observa&ccedil;&otilde;es</label>
                <input type="text" id="observacoes" class="size3" name="observacoes" />
            </div>


        </fieldset>
        <fieldset>
            <legend>Paciente</legend>
            <div>
                <label>Nome</label>
                <input type="text" name="txtNome" class="texto10"/>
            </div>
            <div>
                <label>Dt de nascimento</label>
                <input type="text" name="nascimento" id="txtNascimento" class="texto02" alt="date" onblur="retornaIdade2()"/>
            </div>
            <div>
                
                <input type="hidden" name="idade" id="txtIdade" class="texto01" alt="numeromask"/>
            </div>
            <div>
                <label>Telefone</label>
                <input type="text" id="txtTelefone" class="texto02" name="telefone" alt="phone"/>
            </div>
            <div>
                <label>Celular</label>
                <input type="text" id="txtCelular" class="texto02" name="celular" alt="phone"/>
            </div>
            <div>
                <label>&nbsp;</label>
                <button type="submit" name="btnEnviar">Adicionar</button>
            </div> 

    </form>
</fieldset>


</div> <!-- Final da DIV content -->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript">


$(function() {
        $( "#data_ficha" ).datepicker({
            autosize: true,
            changeYear: true,
            changeMonth: true,
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            buttonImage: '<?= base_url() ?>img/form/date.png',
            dateFormat: 'dd/mm/yy'
        });
    });

    $(function(){
        $('#exame').change(function(){
            if( $(this).val() ) {
                $('#horarios').hide();
                $('.carregando').show();
                $.getJSON('<?= base_url() ?>autocomplete/horariosambulatorio',{exame: $(this).val(), teste: $("#data_ficha").val()}, function(j){
                    var options = '<option value=""></option>';	
                    for (var i = 0; i < j.length; i++) {
                        options += '<option value="' + j[i].agenda_exames_id + '">' + j[i].inicio + '-' + j[i].nome + '- Dr. ' + j[i].medico +'</option>';
                    }	
                    $('#horarios').html(options).show();
                    $('.carregando').hide();
                });
            } else {
                $('#horarios').html('<option value="">-- Escolha um exame --</option>');
            }
        });
    });


    $(function() {
        $( "#accordion" ).accordion();
    });




</script>