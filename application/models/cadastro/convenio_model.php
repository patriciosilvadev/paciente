<?php

class Convenio_model extends Model {

    var $_convenio_id = null;
    var $_nome = null;
    var $_razao_social = null;
    var $_cnpj = null;
    var $_logradouro = null;
    var $_municipio_id = null;
    var $_celular = null;
    var $_telefone = null;
    var $_tipo_logradouro_id = null;
    var $_numero = null;
    var $_bairro = null;
    var $_complemento = null;
    var $_cep = null;
    var $_observacao = null;
    var $_dinheiro = null;
    var $_procedimento1 = null;
    var $_procedimento2 = null;
    var $_tabela = null;
    var $_credor_devedor_id = null;
    var $_conta_id = null;
    var $_enteral = null;
    var $_parenteral = null;

    function Convenio_model($convenio_id = null) {
        parent::Model();
        if (isset($convenio_id)) {
            $this->instanciar($convenio_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('convenio_id,
                            nome');
        $this->db->from('tb_convenio');
        $this->db->where("ativo", 't');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nome ilike', $args['nome'] . "%");
        }
        return $this->db;
    }

    function listardados() {
        $this->db->select('convenio_id,
                            nome,
                            conta_id');
        $this->db->from('tb_convenio');
        $this->db->where("ativo", 't');
        $this->db->orderby("nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarforma() {
        $this->db->select('forma_entradas_saida_id,
                            descricao');
        $this->db->from('tb_forma_entradas_saida');
        $return = $this->db->get();
        return $return->result();
    }
    
    function listarcredordevedor() {
        $this->db->select('financeiro_credor_devedor_id,
                            razao_social,');
        $this->db->from('tb_financeiro_credor_devedor');
        $return = $this->db->get();
        return $return->result();
    }
    
    function listardadosconvenios() {
        $this->db->select('convenio_id,
                            nome');
        $this->db->from('tb_convenio');
        $this->db->where("ativo", 't');
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "" && $_POST['convenio'] != "-1") {
            $this->db->where("convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("dinheiro", "f");
        }
        if ($_POST['convenio'] == "-1") {
            $this->db->where("dinheiro", "t");
        }
        $this->db->orderby("nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarconvenionaodinheiro() {
        $this->db->select('convenio_id,
                            nome');
        $this->db->from('tb_convenio');
        $this->db->where("ativo", 't');
        $this->db->where("dinheiro", 'f');
        $this->db->orderby("nome");
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($convenio_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('convenio_id', $convenio_id);
        $this->db->update('tb_convenio');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function gravar() {
        try {
            /* inicia o mapeamento no banco */
            $convenio_id = $_POST['txtconvenio_id'];
            $this->db->set('nome', $_POST['txtNome']);
            $this->db->set('razao_social', $_POST['txtrazaosocial']);
            $this->db->set('cnpj', $_POST['txtCNPJ']);
            if ($_POST['credor_devedor'] != "") {
            $this->db->set('credor_devedor_id', $_POST['credor_devedor']);
            }
            if ($_POST['conta'] != "") {
            $this->db->set('conta_id', $_POST['conta']);
            }
            $this->db->set('cep', $_POST['cep']);
            if ($_POST['tipo_logradouro'] != "") {
                $this->db->set('tipo_logradouro_id', $_POST['tipo_logradouro']);
            }
            if ($_POST['parenteral'] != "") {
                $this->db->set('parenteral', str_replace(",", ".", $_POST['parenteral']));
            }
            if ($_POST['enteral'] != "") {
                $this->db->set('enteral', str_replace(",", ".", $_POST['enteral']));
            }
            $this->db->set('logradouro', $_POST['endereco']);
            $this->db->set('numero', $_POST['numero']);
            $this->db->set('bairro', $_POST['bairro']);
            $this->db->set('complemento', $_POST['complemento']);
            if ($_POST['municipio_id'] != "") {
                $this->db->set('municipio_id', $_POST['municipio_id']);
            }
            $this->db->set('telefone', $_POST['telefone']);
            $this->db->set('celular', $_POST['celular']);
            $this->db->set('tabela', $_POST['tipo']);
            $this->db->set('procedimento1', $_POST['procedimento1']);
            $this->db->set('procedimento2', $_POST['procedimento2']);
            if (isset($_POST['txtdinheiro'])) {
                $this->db->set('dinheiro', $_POST['txtdinheiro']);
            }
            $this->db->set('observacao', $_POST['txtObservacao']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtconvenio_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_convenio');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $exame_sala_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $exame_sala_id = $_POST['txtconvenio_id'];
                $this->db->where('convenio_id', $convenio_id);
                $this->db->update('tb_convenio');
            }
            return $exame_sala_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarcopia() {
        try {
            $convenio = $_POST['txtconvenio'];
            $convenioidnovo = $_POST['txtconvenio_id'];
            $sql = "INSERT INTO ponto.tb_procedimento_convenio(
            convenio_id, procedimento_tuss_id, 
            qtdech, valorch, qtdefilme, valorfilme, qtdeporte, valorporte, 
            qtdeuco, valoruco, valortotal, ativo, data_cadastro, operador_cadastro, 
            data_atualizacao, operador_atualizacao)
            SELECT $convenioidnovo, procedimento_tuss_id, 
            qtdech, valorch, qtdefilme, valorfilme, qtdeporte, valorporte, 
            qtdeuco, valoruco, valortotal, ativo, data_cadastro, operador_cadastro, 
            data_atualizacao, operador_atualizacao
            FROM ponto.tb_procedimento_convenio
                where convenio_id = $convenio";
            $this->db->query($sql);

            return $convenioidnovo;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($convenio_id) {

        if ($convenio_id != 0) {
            $this->db->select('convenio_id,
                                co.nome,
                                co.dinheiro,
                                co.celular,
                                co.observacao,
                                co.cep,
                                co.complemento,
                                co.bairro,
                                co.numero,
                                co.tipo_logradouro_id,
                                co.telefone,
                                co.municipio_id,
                                co.logradouro,
                                co.cnpj,
                                co.dinheiro,
                                co.procedimento1,
                                co.procedimento2,
                                co.tabela,
                                co.conta_id,
                                co.enteral,
                                co.parenteral,
                                co.credor_devedor_id,
                                co.razao_social');
            $this->db->from('tb_convenio co');
            $this->db->join('tb_municipio c', 'c.municipio_id = co.municipio_id', 'left');
            $this->db->join('tb_tipo_logradouro tp', 'tp.tipo_logradouro_id = co.tipo_logradouro_id', 'left');
            $this->db->where("convenio_id", $convenio_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_convenio_id = $convenio_id;
            $this->_nome = $return[0]->nome;
            $this->_razao_social = $return[0]->razao_social;
            $this->_cnpj = $return[0]->cnpj;
            $this->_logradouro = $return[0]->logradouro;
            $this->_municipio_id = $return[0]->municipio_id;
            $this->_celular = $return[0]->celular;
            $this->_telefone = $return[0]->telefone;
            $this->_tipo_logradouro_id = $return[0]->tipo_logradouro_id;
            $this->_numero = $return[0]->numero;
            $this->_bairro = $return[0]->bairro;
            $this->_complemento = $return[0]->complemento;
            $this->_cep = $return[0]->cep;
            $this->_observacao = $return[0]->observacao;
            $this->_dinheiro = $return[0]->dinheiro;
            $this->_procedimento1 = $return[0]->procedimento1;
            $this->_procedimento2 = $return[0]->procedimento2;
            $this->_tabela = $return[0]->tabela;
            $this->_credor_devedor_id = $return[0]->credor_devedor_id;
            $this->_conta_id = $return[0]->conta_id;
            $this->_enteral= $return[0]->enteral;
            $this->_parenteral = $return[0]->parenteral;
        } else {
            $this->_convenio_id = null;
        }
    }

}

?>
