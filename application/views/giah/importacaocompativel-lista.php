<div class="content"> <!-- Inicio da DIV content -->
        <div id="accordion">
 
        <form method="post" action="<?= base_url();?>giah/importacaoopm/importarCompativel"  enctype="multipart/form-data">
            <label>Informe o arquivo para importa&ccedil;&atilde;o</label><br/>
            <input type="file" name="userfile" />
            <button type="submit" name="btnEnviar">Enviar</button>
        </form>
 
        <div style="width: 400px; margin: 0">
        <?
            if (isset ($erros)) :
                echo $erros;
            endif;

        ?>
      </div>
</div>
</div> <!-- Final da DIV content -->
<link rel="stylesheet" href="<?= base_url()?>css/jquery-ui-1.8.5.custom.css">
<script type="text/javascript">

    $(function() {
        $( "#accordion" ).accordion();
    });



</script>
