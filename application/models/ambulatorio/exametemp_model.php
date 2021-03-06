<?php

class exametemp_model extends Model {

    var $_ambulatorio_pacientetemp_id = null;
    var $_nome = null;
    var $_nascimento = null;
    var $_idade = null;
    var $_celular = null;
    var $_telefone = null;

    function Exametemp_model($ambulatorio_pacientetemp_id = null) {
        parent::Model();
        if (isset($ambulatorio_pacientetemp_id)) {
            $this->instanciar($ambulatorio_pacientetemp_id);
        }
    }

    function listarmedicoconsulta() {
        $this->db->select('operador_id,
            nome');
        $this->db->from('tb_operador');
        $this->db->where('consulta', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listar($args = array()) {
        $this->db->select('ambulatorio_pacientetemp_id,
                            nome,
                            idade,
                            celular,
                            telefone');
        $this->db->from('tb_ambulatorio_pacientetemp');
        $this->db->where("ativo", 't');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nome ilike', "%" . $args['nome'] . "%");
            $this->db->orwhere('celular ilike', "%" . $args['nome'] . "%");
            $this->db->orwhere('telefone ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function listaragendas($ambulatorio_pacientetemp_id) {
        $this->db->select('agenda_exames_id,
                            inicio,
                            data,
                            nome,
                            observacoes');
        $this->db->from('tb_agenda_exames');
        $this->db->where("ambulatorio_pacientetemp_id", $ambulatorio_pacientetemp_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listaragendaspaciente($pacientetemp_id) {
        $data = date("Y-m-d");
//        var_dump($data);
//        die;
        $this->db->select('a.agenda_exames_id,
                            a.inicio,
                            a.data,
                            a.nome,
                            a.data,
                            a.agenda_exames_nome_id,
                            es.nome as sala,
                            a.medico_agenda,
                            o.nome as medico,
                            a.observacoes');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_agenda', 'left');
        $this->db->where("a.confirmado", 'false');
        $this->db->where("a.tipo", 'EXAME');
        $this->db->where('a.data', $data);
        $this->db->where('a.ativo', 'false');
        $this->db->where("a.paciente_id", $pacientetemp_id);
        $this->db->orderby("a.data desc");
        $this->db->orderby("a.inicio desc");
        $return = $this->db->get();
        return $return->result();
    }

    function listaragendaspacienteconsulta($pacientetemp_id) {
        $data = date("Y-m-d");
//        var_dump($data);
//        die;
        $this->db->select('a.agenda_exames_id,
                            a.inicio,
                            a.data,
                            a.nome,
                            a.data,
                            a.medico_consulta_id,
                            a.agenda_exames_nome_id,
                            es.nome as sala,
                            a.medico_agenda,
                            o.nome as medico,
                            a.observacoes');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_consulta_id', 'left');
        $this->db->where("a.confirmado", 'false');
        $this->db->where("a.tipo", 'CONSULTA');
        $this->db->where('a.data', $data);
        $this->db->where('a.ativo', 'false');
        $this->db->where("a.paciente_id", $pacientetemp_id);
        $this->db->orderby("a.data desc");
        $this->db->orderby("a.inicio desc");
        $return = $this->db->get();
        return $return->result();
    }

    function listaragendaspacientefisioterapia($pacientetemp_id) {
        $data = date("Y-m-d");
//        var_dump($data);
//        die;
        $this->db->select('a.agenda_exames_id,
                            a.inicio,
                            a.data,
                            a.nome,
                            a.data,
                            a.medico_consulta_id,
                            a.agenda_exames_nome_id,
                            es.nome as sala,
                            a.medico_agenda,
                            o.nome as medico,
                            a.observacoes');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_agenda', 'left');
        $this->db->where("a.confirmado", 'false');
        $this->db->where("a.tipo", 'FISIOTERAPIA');
        $this->db->where("a.guia_id", null);
        $this->db->where('a.data', $data);
        $this->db->where('a.ativo', 'false');
        $this->db->where("a.paciente_id", $pacientetemp_id);
        $this->db->orderby("a.data desc");
        $this->db->orderby("a.inicio desc");
        $return = $this->db->get();
        return $return->result();
    }

    function listaragendatotalpaciente($pacientetemp_id) {
        $data = date("Y-m-d");
        $this->db->select('a.agenda_exames_id,
                            a.inicio,
                            a.data,
                            a.nome,
                            a.data,
                            a.agenda_exames_nome_id,
                            es.nome as sala,
                            a.medico_agenda,
                            o.nome as medico,
                            a.observacoes');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_agenda', 'left');
        $this->db->where("a.tipo", 'EXAME');
        $this->db->where("a.confirmado", 'false');
        $this->db->where('a.ativo', 'false');
        $this->db->where("a.paciente_id", $pacientetemp_id);
        $this->db->orderby("a.data desc");
        $this->db->orderby("a.inicio desc");
        $return = $this->db->get();
        return $return->result();
    }

    function listaragendatotalpacienteconsulta($pacientetemp_id) {
        $data = date("Y-m-d");
        $this->db->select('a.agenda_exames_id,
                            a.inicio,
                            a.data,
                            a.nome,
                            a.data,
                            a.agenda_exames_nome_id,
                            es.nome as sala,
                            a.medico_agenda,
                            o.nome as medico,
                            a.medico_consulta_id,
                            a.observacoes');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_consulta_id', 'left');
        $this->db->where("a.tipo", 'CONSULTA');
        $this->db->where("a.confirmado", 'false');
        $this->db->where('a.ativo', 'false');
        $this->db->where("a.paciente_id", $pacientetemp_id);
        $this->db->orderby("a.data desc");
        $this->db->orderby("a.inicio desc");
        $return = $this->db->get();
        return $return->result();
    }

    function listaragendatotalpacientefisioterapia($pacientetemp_id) {
        $data = date("Y-m-d");
        $this->db->select('a.agenda_exames_id,
                            a.inicio,
                            a.data,
                            a.nome,
                            a.data,
                            a.agenda_exames_nome_id,
                            es.nome as sala,
                            a.medico_agenda,
                            o.nome as medico,
                            a.medico_consulta_id,
                            a.observacoes');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_consulta_id', 'left');
        $this->db->where("a.tipo", 'FISIOTERAPIA');
        $this->db->where("a.confirmado", 'false');
        $this->db->where('a.ativo', 'false');
        $this->db->where("a.paciente_id", $pacientetemp_id);
        $this->db->orderby("a.data desc");
        $this->db->orderby("a.inicio desc");
        $return = $this->db->get();
        return $return->result();
    }

    function listarconsultaanterior($pacientetemp_id) {
        $data = date("Y-m-d");
        $this->db->select('a.agenda_exames_id,
                            a.inicio,
                            a.data,
                            a.nome,
                            a.data,
                            a.agenda_exames_nome_id,
                            es.nome as sala,
                            a.medico_agenda,
                            o.nome as medico,
                            c.nome as convenio,
                            a.medico_consulta_id,
                            a.procedimento_tuss_id,
                            pt.nome as procedimento,
                            a.observacoes');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_consulta_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = a.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("a.tipo", 'CONSULTA');
        $this->db->where("a.confirmado", 'true');
        $this->db->where("a.paciente_id", $pacientetemp_id);
        $this->db->orderby("a.data desc");
        $this->db->orderby("a.inicio desc");
        $this->db->limit(5);
        $return = $this->db->get();
        return $return->result();
    }

    function listarconsultaanteriorcontador($pacientetemp_id) {
        $data = date("Y-m-d");
        $this->db->select('a.agenda_exames_id,
                            a.inicio,
                            a.data,
                            a.nome,
                            a.data,
                            a.agenda_exames_nome_id,
                            es.nome as sala,
                            a.medico_agenda,
                            o.nome as medico,
                            a.medico_consulta_id,
                            a.procedimento_tuss_id,
                            pt.nome as procedimento,
                            a.observacoes');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_consulta_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = a.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("a.tipo", 'CONSULTA');
        $this->db->where("a.confirmado", 'true');
        $this->db->where("a.paciente_id", $pacientetemp_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function listaragendasexamepaciente($agenda_exames_id) {
        $this->db->select('a.agenda_exames_id,
                            a.inicio,
                            a.data,
                            a.nome,
                            es.nome as sala,
                            a.medico_agenda,
                            a.observacoes');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
        $this->db->where("a.agenda_exames_id", $agenda_exames_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listaragendasconsultapaciente($agenda_exames_id) {
        $this->db->select('a.agenda_exames_id,
                            a.inicio,
                            a.data,
                            a.nome,
                            o.nome as medico,
                            a.medico_agenda,
                            a.observacoes');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_consulta_id', 'left');
        $this->db->where("a.agenda_exames_id", $agenda_exames_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listaraexamespaciente($ambulatorio_guia_id) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.valor_total,
                            ae.ativo,
                            ae.situacao,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.faturado,
                            pc.convenio_id,
                            ae.medico_agenda as medico_agenda_id,
                            op.nome as medico_agenda,
                            ae.medico_solicitante as medico_solicitante_id,
                            o.nome as medico_solicitante,
                            es.nome as sala,
                            p.nome as paciente,
                            c.dinheiro,
                            ae.ordenador,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.medico_agenda', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.confirmado', 'true');
        $this->db->where('ae.ativo', 'false');
        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where("guia_id", $ambulatorio_guia_id);
        $this->db->orderby("ae.data");
        $this->db->orderby("ae.inicio");
        $return = $this->db->get();
        return $return->result();
    }

    function contadorexamespaciente($ambulatorio_guia_id) {
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.situacao,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            an.nome as sala,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_agenda_exames_nome an', 'an.agenda_exames_nome_id = ae.agenda_exames_nome_id', 'left');
        $this->db->where('ae.confirmado', 'true');
        $this->db->where('ae.ativo', 'false');
        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where("guia_id", $ambulatorio_guia_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function contadorpacienteexame($paciente_id) {
        $this->db->select('paciente_id');
        $this->db->from('tb_exames');
        $this->db->where('cancelada', 'false');
        $this->db->where("paciente_id", $paciente_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function contadorpacienteguia($paciente_id) {
        $this->db->select('paciente_id');
        $this->db->from('tb_ambulatorio_guia');
        $this->db->where('ativo', 'true');
        $this->db->where("paciente_id", $paciente_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function contadorpacienteconsulta($paciente_id) {
        $this->db->select('paciente_id');
        $this->db->from('tb_ambulatorio_consulta');
        $this->db->where("paciente_id", $paciente_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function contadorpacientelaudo($paciente_id) {
        $this->db->select('paciente_id');
        $this->db->from('tb_ambulatorio_laudo');
        $this->db->where("paciente_id", $paciente_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function contador($ambulatorio_pacientetemp_id) {
        $this->db->select();
        $this->db->from('tb_agenda_exames');
        $this->db->where('ambulatorio_pacientetemp_id', $ambulatorio_pacientetemp_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function contadorpaciente($pacientetemp_id) {
        $this->db->select();
        $this->db->from('tb_agenda_exames');
        $this->db->where("tipo", 'EXAME');
        $this->db->where('confirmado', 'false');
        $this->db->where('ativo', 'false');
        $this->db->where('paciente_id', $pacientetemp_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function contadorconsultapaciente($pacientetemp_id) {
        $this->db->select();
        $this->db->from('tb_agenda_exames');
        $this->db->where("tipo", 'CONSULTA');
        $this->db->where('confirmado', 'false');
        $this->db->where('ativo', 'false');
        $this->db->where('paciente_id', $pacientetemp_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function contadorfisioterapiapaciente($pacientetemp_id) {
        $this->db->select();
        $this->db->from('tb_agenda_exames');
        $this->db->where("tipo", 'FISIOTERAPIA');
        $this->db->where('confirmado', 'false');
        $this->db->where('ativo', 'false');
        $this->db->where('paciente_id', $pacientetemp_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function gravarexames($ambulatorio_pacientetemp_id) {
        try {
            $this->db->set('nome', $_POST['txtNome']);
            if ($_POST['nascimento'] != '//' && $_POST['nascimento'] != '') {
                $this->db->set('nascimento', $_POST['nascimento']);
            }
            if ($_POST['idade'] != 0) {
                $this->db->set('idade', $_POST['idade']);
            }
            $this->db->set('celular', $_POST['telefone']);
            $this->db->set('telefone', $_POST['celular']);
            $this->db->where('paciente_id', $ambulatorio_pacientetemp_id);
            $this->db->update('tb_paciente');

            if ($_POST['horarios'] != "") {
                $empresa_id = $this->session->userdata('empresa_id');
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('tipo', 'EXAME');
                $this->db->set('ativo', 'f');
                $this->db->set('cancelada', 'f');
                $this->db->set('confirmado', 'f');
                $this->db->set('situacao', 'OK');
                $this->db->set('observacoes', $_POST['observacoes']);
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');
                $this->db->set('paciente_id', $ambulatorio_pacientetemp_id);
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('agenda_exames_id', $_POST['horarios']);
                $this->db->update('tb_agenda_exames');
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarconsultas($ambulatorio_pacientetemp_id) {
        try {
            $this->db->set('nome', $_POST['txtNome']);
            if ($_POST['nascimento'] != '//' && $_POST['nascimento'] != '') {
                $this->db->set('nascimento', $_POST['nascimento']);
            }
            if ($_POST['idade'] != 0) {
                $this->db->set('idade', $_POST['idade']);
            }
            $this->db->set('celular', $_POST['telefone']);
            $this->db->set('telefone', $_POST['celular']);
            $this->db->set('convenio_id', $_POST['convenio']);
            $this->db->where('paciente_id', $ambulatorio_pacientetemp_id);
            $this->db->update('tb_paciente');

            if ($_POST['horarios'] != "") {
                $empresa_id = $this->session->userdata('empresa_id');
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('tipo', 'CONSULTA');
                $this->db->set('ativo', 'f');
                $this->db->set('cancelada', 'f');
                $this->db->set('confirmado', 'f');
                $this->db->set('situacao', 'OK');
                $this->db->set('observacoes', $_POST['observacoes']);
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');
                $this->db->set('paciente_id', $ambulatorio_pacientetemp_id);
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('agenda_exames_id', $_POST['horarios']);
                $this->db->update('tb_agenda_exames');
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarfisioterapia($ambulatorio_pacientetemp_id) {
        try {
            $this->db->set('nome', $_POST['txtNome']);
            if ($_POST['nascimento'] != '//' && $_POST['nascimento'] != '') {
                $this->db->set('nascimento', $_POST['nascimento']);
            }
            if ($_POST['idade'] != 0) {
                $this->db->set('idade', $_POST['idade']);
            }
            $this->db->set('celular', $_POST['telefone']);
            $this->db->set('telefone', $_POST['celular']);
            $this->db->set('convenio_id', $_POST['convenio']);
            $this->db->where('paciente_id', $ambulatorio_pacientetemp_id);
            $this->db->update('tb_paciente');

            if ($_POST['horarios'] != "") {
                $empresa_id = $this->session->userdata('empresa_id');
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('tipo', 'FISIOTERAPIA');
                $this->db->set('ativo', 'f');
                $this->db->set('cancelada', 'f');
                $this->db->set('confirmado', 'f');
                $this->db->set('situacao', 'OK');
                $this->db->set('observacoes', $_POST['observacoes']);
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');
                $this->db->set('paciente_id', $ambulatorio_pacientetemp_id);
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('agenda_exames_id', $_POST['horarios']);
                $this->db->update('tb_agenda_exames');
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarconsultasencaixe() {
        try {


            $this->db->select('nome');
            $this->db->from('tb_operador');
            $this->db->where('operador_id', $_POST['medico']);
            $query = $this->db->get();
            $return = $query->result();
            $nome = substr($return[0]->nome, 0, 10);


            if ($_POST['txtNomeid'] == '') {
                if ($_POST['nascimento'] != '') {
                    $this->db->set('nascimento', $_POST['nascimento']);
                }
                if ($_POST['idade'] != 0) {
                    $this->db->set('idade', $_POST['idade']);
                }
                $this->db->set('celular', $_POST['celular']);
                $this->db->set('convenio_id', $_POST['convenio']);
                $this->db->set('telefone', $_POST['telefone']);
                $this->db->set('nome', $_POST['txtNome']);
                $this->db->insert('tb_paciente');
                $paciente_id = $this->db->insert_id();
            } else {
                $paciente_id = $_POST['txtNomeid'];
            }



            if ($_POST['horarios'] != "") {
                $empresa_id = $this->session->userdata('empresa_id');
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('tipo', 'CONSULTA');
                $this->db->set('medico_consulta_id', $_POST['medico']);
                $this->db->set('nome', $nome);
                $this->db->set('ativo', 'f');
                $this->db->set('cancelada', 'f');
                $this->db->set('confirmado', 'f');
                $this->db->set('situacao', 'OK');
                $this->db->set('observacoes', $_POST['observacoes']);
                $data = date("Y-m-d");
                $hora = date("H:i:s");
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');

                $this->db->set('paciente_id', $paciente_id);
                $this->db->set('data_inicio', $_POST['data_ficha']);
                $this->db->set('fim', $_POST['horarios']);
                $this->db->set('inicio', $_POST['horarios']);
                $this->db->set('data_fim', $_POST['data_ficha']);
                $this->db->set('data', $_POST['data_ficha']);
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_agenda_exames');
            }
            return $paciente_id;
        } catch (Exception $exc) {
            return $paciente_id;
        }
    }

    function gravarfisioterapiaencaixe() {
        try {


            $this->db->select('nome');
            $this->db->from('tb_operador');
            $this->db->where('operador_id', $_POST['medico']);
            $query = $this->db->get();
            $return = $query->result();
            $nome = substr($return[0]->nome, 0, 10);


            if ($_POST['txtNomeid'] == '') {
                if ($_POST['nascimento'] != '') {
                    $this->db->set('nascimento', $_POST['nascimento']);
                }
                if ($_POST['idade'] != 0) {
                    $this->db->set('idade', $_POST['idade']);
                }
                $this->db->set('celular', $_POST['celular']);
                $this->db->set('convenio_id', $_POST['convenio']);
                $this->db->set('telefone', $_POST['telefone']);
                $this->db->set('nome', $_POST['txtNome']);
                $this->db->insert('tb_paciente');
                $paciente_id = $this->db->insert_id();
            } else {
                $paciente_id = $_POST['txtNomeid'];
            }



            if ($_POST['horarios'] != "") {
                $empresa_id = $this->session->userdata('empresa_id');
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('tipo', 'FISIOTERAPIA');
                $this->db->set('medico_consulta_id', $_POST['medico']);
                $this->db->set('nome', $nome);
                $this->db->set('ativo', 'f');
                $this->db->set('cancelada', 'f');
                $this->db->set('confirmado', 'f');
                $this->db->set('situacao', 'OK');
                $this->db->set('observacoes', $_POST['observacoes']);
                $data = date("Y-m-d");
                $hora = date("H:i:s");
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');

                $this->db->set('paciente_id', $paciente_id);
                $this->db->set('data_inicio', $_POST['data_ficha']);
                $this->db->set('fim', $_POST['horarios']);
                $this->db->set('inicio', $_POST['horarios']);
                $this->db->set('data_fim', $_POST['data_ficha']);
                $this->db->set('data', $_POST['data_ficha']);
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_agenda_exames');
            }
            return $paciente_id;
        } catch (Exception $exc) {
            return $paciente_id;
        }
    }

    function gravaconsultasencaixe($ambulatorio_pacientetemp_id) {
        try {

            $this->db->select('nome');
            $this->db->from('tb_operador');
            $this->db->where('operador_id', $_POST['medico']);
            $query = $this->db->get();
            $return = $query->result();
            $nome = substr($return[0]->nome, 0, 10);
            if ($_POST['horarios'] != "") {
                $empresa_id = $this->session->userdata('empresa_id');
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('tipo', 'CONSULTA');
                $this->db->set('nome', $nome);
                $this->db->set('medico_consulta_id', $_POST['medico']);
                $this->db->set('ativo', 'f');
                $this->db->set('cancelada', 'f');
                $this->db->set('confirmado', 'f');
                $this->db->set('situacao', 'OK');
                $this->db->set('observacoes', $_POST['observacoes']);
                $data = date("Y-m-d");
                $hora = date("H:i:s");
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');

                $this->db->set('paciente_id', $ambulatorio_pacientetemp_id);
                $this->db->set('data_inicio', $_POST['data_ficha']);
                $this->db->set('fim', $_POST['horarios']);
                $this->db->set('inicio', $_POST['horarios']);
                $this->db->set('data_fim', $_POST['data_ficha']);
                $this->db->set('data', $_POST['data_ficha']);
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_agenda_exames');
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarconsultaspacienteexistente($ambulatorio_pacientetemp_id) {
        try {
            $this->db->set('nome', $_POST['txtNome']);
            if ($_POST['nascimento'] != '//' && $_POST['nascimento'] != '') {
                $this->db->set('nascimento', $_POST['nascimento']);
            }
            if ($_POST['idade'] != 0) {
                $this->db->set('idade', $_POST['idade']);
            }
            $this->db->set('celular', $_POST['telefone']);
            $this->db->set('telefone', $_POST['celular']);
//            $this->db->set('convenio_id', $_POST['convenio']);
            $this->db->where('paciente_id', $ambulatorio_pacientetemp_id);
            $this->db->update('tb_paciente');

            if ($_POST['horarios'] != "") {
                $empresa_id = $this->session->userdata('empresa_id');
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('tipo', 'CONSULTA');
                $this->db->set('ativo', 'f');
                $this->db->set('cancelada', 'f');
                $this->db->set('confirmado', 'f');
                $this->db->set('situacao', 'OK');
                $this->db->set('observacoes', $_POST['observacoes']);
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');
                $this->db->set('paciente_id', $ambulatorio_pacientetemp_id);
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('agenda_exames_id', $_POST['horarios']);
                $this->db->update('tb_agenda_exames');
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarfisioterapiapacienteexistente($ambulatorio_pacientetemp_id) {
        try {
            $this->db->set('nome', $_POST['txtNome']);
            if ($_POST['nascimento'] != '//' && $_POST['nascimento'] != '') {
                $this->db->set('nascimento', $_POST['nascimento']);
            }
            if ($_POST['idade'] != 0) {
                $this->db->set('idade', $_POST['idade']);
            }
            $this->db->set('celular', $_POST['telefone']);
            $this->db->set('telefone', $_POST['celular']);
//            $this->db->set('convenio_id', $_POST['convenio']);
            $this->db->where('paciente_id', $ambulatorio_pacientetemp_id);
            $this->db->update('tb_paciente');

            if ($_POST['horarios'] != "") {
                $empresa_id = $this->session->userdata('empresa_id');
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('tipo', 'FISIOTERAPIA');
                $this->db->set('ativo', 'f');
                $this->db->set('cancelada', 'f');
                $this->db->set('confirmado', 'f');
                $this->db->set('situacao', 'OK');
                $this->db->set('observacoes', $_POST['observacoes']);
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');
                $this->db->set('paciente_id', $ambulatorio_pacientetemp_id);
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('agenda_exames_id', $_POST['horarios']);
                $this->db->update('tb_agenda_exames');
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarunificacao() {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('antigopaciente_id', $_POST['pacienteid']);
            $this->db->set('paciente_id', $_POST['paciente_id']);
            $this->db->set('data_unificacao', $horario);
            $this->db->set('operador_unificacao', $operador_id);
            $this->db->where('paciente_id', $_POST['pacienteid']);
            $this->db->update('tb_exames');

            $this->db->set('antigopaciente_id', $_POST['pacienteid']);
            $this->db->set('paciente_id', $_POST['paciente_id']);
            $this->db->set('data_unificacao', $horario);
            $this->db->set('operador_unificacao', $operador_id);
            $this->db->where('paciente_id', $_POST['pacienteid']);
            $this->db->update('tb_agenda_exames');

            $this->db->set('antigopaciente_id', $_POST['pacienteid']);
            $this->db->set('paciente_id', $_POST['paciente_id']);
            $this->db->set('data_unificacao', $horario);
            $this->db->set('operador_unificacao', $operador_id);
            $this->db->where('paciente_id', $_POST['pacienteid']);
            $this->db->update('tb_ambulatorio_consulta');

            $this->db->set('antigopaciente_id', $_POST['pacienteid']);
            $this->db->set('paciente_id', $_POST['paciente_id']);
            $this->db->set('data_unificacao', $horario);
            $this->db->set('operador_unificacao', $operador_id);
            $this->db->where('paciente_id', $_POST['pacienteid']);
            $this->db->update('tb_ambulatorio_guia');

            $this->db->set('antigopaciente_id', $_POST['pacienteid']);
            $this->db->set('paciente_id', $_POST['paciente_id']);
            $this->db->set('data_unificacao', $horario);
            $this->db->set('operador_unificacao', $operador_id);
            $this->db->where('paciente_id', $_POST['pacienteid']);
            $this->db->update('tb_ambulatorio_laudo');

            if ($_POST['pacienteid'] != $_POST['paciente_id']) {
                $this->db->set('ativo', 'f');
                $this->db->set('data_exclusao', $horario);
                $this->db->set('operador_exclusao', $operador_id);
                $this->db->where('paciente_id', $_POST['pacienteid']);
                $this->db->update('tb_paciente');
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarpacienteexames($agenda_exames_id, $paciente_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('ativo', 'f');
            $this->db->set('cancelada', 'f');
            $this->db->set('confirmado', 'f');
            $this->db->set('internet', 't');
            $this->db->set('situacao', 'OK');
            $this->db->set('observacoes', $_POST['observacoes']);
            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('data_atualizacao', $horario);
            $this->db->where('agenda_exames_id', $agenda_exames_id);
            $this->db->update('tb_agenda_exames');
            return $paciente_id;
        } catch (Exception $exc) {
            return $paciente_id;
        }
    }

    function gravarpacienteconsultas($agenda_exames_id) {
        try {
//            if(){


            $this->db->select('paciente_id');
            $this->db->from('tb_paciente');
            $this->db->where("ativo", 't');
            $this->db->where("cpf", $_POST['Txtcpf']);
            $query = $this->db->get();
            $return = $query->result();
//            }

            $this->db->select('ag.tipo');
            $this->db->from('tb_procedimento_convenio pc');
            $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
            $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo', 'left');
            $this->db->where('pc.procedimento_convenio_id', $_POST['procedimento']);
            $return2 = $this->db->get()->result();
            $tipo = $return2[0]->tipo;
//            echo '<pre>';
//            var_dump($tipo);
//            die;
            if (count($return) > 0) {
                $paciente_id = $return[0]->paciente_id;
            } else {
                if ($_POST['txtNomeid'] == '') {
                    if ($_POST['nascimento'] != '') {
                        $this->db->set('nascimento', $_POST['nascimento']);
                    }
                    $this->db->set('cpf', $_POST['Txtcpf']);
                    $this->db->set('celular', $_POST['celular']);
                    $this->db->set('convenio_id', $_POST['convenio']);
                    $this->db->set('telefone', $_POST['telefone']);
                    $this->db->set('nome', $_POST['txtNome']);
                    $this->db->insert('tb_paciente');
                    $paciente_id = $this->db->insert_id();
                } else {
                    $paciente_id = $_POST['txtNomeid'];
                }
            }

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $empresa_id = $this->session->userdata('empresa_id');
//            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('procedimento_tuss_id', $_POST['procedimento']);
//                $this->db->set('empresa_id', $empresa_id);
            $this->db->set('tipo', $tipo);
            $this->db->set('ativo', 'f');
            $this->db->set('cancelada', 'f');
            $this->db->set('confirmado', 'f');
            $this->db->set('situacao', 'OK');
            $this->db->set('observacoes', $_POST['observacoes']);
            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('agenda_exames_id', $agenda_exames_id);
            $this->db->update('tb_agenda_exames');
            return $paciente_id;
        } catch (Exception $exc) {
            return $paciente_id;
        }
    }

    function gravarpacientefisioterapia($agenda_exames_id) {
        try {
            if ($_POST['txtNomeid'] == '') {
                if ($_POST['nascimento'] != '') {
                    $this->db->set('nascimento', $_POST['nascimento']);
                }
                if ($_POST['idade'] != 0) {
                    $this->db->set('idade', $_POST['idade']);
                }
                $this->db->set('celular', $_POST['celular']);
                $this->db->set('convenio_id', $_POST['convenio']);
                $this->db->set('telefone', $_POST['telefone']);
                $this->db->set('nome', $_POST['txtNome']);
                $this->db->insert('tb_paciente');
                $paciente_id = $this->db->insert_id();
            } else {
                $paciente_id = $_POST['txtNomeid'];
            }
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('tipo', 'FISIOTERAPIA');
            $this->db->set('ativo', 'f');
            $this->db->set('cancelada', 'f');
            $this->db->set('confirmado', 'f');
            $this->db->set('situacao', 'OK');
            $this->db->set('observacoes', $_POST['observacoes']);
            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('agenda_exames_id', $agenda_exames_id);
            $this->db->update('tb_agenda_exames');
            return $paciente_id;
        } catch (Exception $exc) {
            return $paciente_id;
        }
    }

    function reservarexametemp($agenda_exames_id, $paciente_id, $agenda_exames_nome_id, $data) {
        try {

            $agenda_exames2 = $agenda_exames_id + 1;
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('tipo', 'EXAME');
            $this->db->set('ativo', 'f');
            $this->db->set('situacao', 'OK');
            $this->db->set('observacoes', 'reservado');
            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('paciente_id is null');
            $this->db->where('data', $data);
            $this->db->where('agenda_exames_nome_id', $agenda_exames_nome_id);
            $this->db->where('agenda_exames_id', $agenda_exames2);
            $this->db->update('tb_agenda_exames');
            return $paciente_id;
        } catch (Exception $exc) {
            return $paciente_id;
        }
    }

    function reservarconsultatemp($agenda_exames_id, $paciente_id, $medico_consulta_id, $data) {
        try {

            $agenda_exames2 = $agenda_exames_id + 1;
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('tipo', 'CONSULTA');
            $this->db->set('ativo', 'f');
            $this->db->set('situacao', 'OK');
            $this->db->set('observacoes', 'reservado');
            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('paciente_id is null');
            $this->db->where('data', $data);
            $this->db->where('medico_consulta_id', $medico_consulta_id);
            $this->db->where('agenda_exames_id', $agenda_exames2);
            $this->db->update('tb_agenda_exames');
            return $paciente_id;
        } catch (Exception $exc) {
            return $paciente_id;
        }
    }

    function reservarfisioterapiatemp($agenda_exames_id, $paciente_id, $medico_consulta_id, $data) {
        try {

            $agenda_exames2 = $agenda_exames_id + 1;
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('tipo', 'FISIOTERAPIA');
            $this->db->set('ativo', 'f');
            $this->db->set('situacao', 'OK');
            $this->db->set('observacoes', 'reservado');
            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('paciente_id is null');
            $this->db->where('data', $data);
            $this->db->where('medico_consulta_id', $medico_consulta_id);
            $this->db->where('agenda_exames_id', $agenda_exames2);
            $this->db->update('tb_agenda_exames');
            return $paciente_id;
        } catch (Exception $exc) {
            return $paciente_id;
        }
    }

    function substituirpacientetemp($paciente_id, $paciente_temp_id) {
        try {
            $i = 0;
            $confimado = "";
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_ambulatorio_guia');
            $ambulatorio_guia_id = $this->db->insert_id();
            foreach ($_POST['procedimento'] as $procedimento_tuss_id) {
                $z = 0;
                $c = 0;
                $d = 0;
                $y = 0;
                $x = 0;
                $w = 0;
                $b = 0;
                $i++;
                foreach ($_POST['qtde'] as $itemnome) {
                    $c++;
                    if ($i == $c) {
                        $qtde = $itemnome;
                        break;
                    }
                }
                foreach ($_POST['valor'] as $itemnome) {
                    $z++;
                    if ($i == $z) {
                        $valor = $itemnome;
                        break;
                    }
                }
                foreach ($_POST['valortotal'] as $itemnome) {
                    $d++;
                    if ($i == $d) {
                        $valortotal = $itemnome;
                        break;
                    }
                }
                foreach ($_POST['convenio'] as $itemconvenio) {
                    $w++;
                    if ($i == $w) {
                        $convenio = $itemconvenio;
                        break;
                    }
                }
                foreach ($_POST['autorizacao'] as $itemautorizacao) {
                    $b++;
                    if ($i == $b) {
                        $autorizacao = $itemautorizacao;
                        break;
                    }
                }
                foreach ($_POST['agenda_exames_id'] as $itemagenda_exames_id) {
                    $x++;
                    if ($i == $x) {
                        $agenda_exames_id = $itemagenda_exames_id;
                        break;
                    }
                }
                foreach ($_POST['confimado'] as $key => $itemconfimado) {
                    $y++;
                    if ($i == $key) {
                        $confimado = $itemconfimado;
                        break;
                    }
                }
                $procedimento_tuss_id = (int) $procedimento_tuss_id;
                $agenda_exames_id = (int) $agenda_exames_id;
                if ($confimado == "on" && $procedimento_tuss_id > 0) {
                    $empresa_id = $this->session->userdata('empresa_id');
                    $this->db->set('empresa_id', $empresa_id);
                    $this->db->set('tipo', 'EXAME');
                    $this->db->set('paciente_id', $paciente_id);
                    $this->db->set('procedimento_tuss_id', $procedimento_tuss_id);
                    $this->db->set('convenio_id', $convenio);
                    $this->db->set('autorizacao', $autorizacao);
                    $this->db->set('guia_id', $ambulatorio_guia_id);
                    $this->db->set('quantidade', $qtde);
                    $this->db->set('valor', str_replace(",", ".", str_replace(".", "", $valor)));
                    $this->db->set('valor_total', str_replace(",", ".", str_replace(".", "", $valortotal)));
                    $this->db->set('confirmado', 't');
                    $horario = date("Y-m-d H:i:s");
                    $operador_id = $this->session->userdata('operador_id');
                    $this->db->set('ambulatorio_pacientetemp_id', null);
                    $this->db->set('data_atualizacao', $horario);
                    $this->db->set('operador_atualizacao', $operador_id);
                    $this->db->where('agenda_exames_id', $agenda_exames_id);
                    $this->db->update('tb_agenda_exames');
                    $confimado = "";
                }
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarguia($paciente_id) {
        $horario = date("Y-m-d H:i:s");
        $data = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->set('tipo', 'EXAME');
        $this->db->set('empresa_id', $empresa_id);
        $this->db->set('data_criacao', $data);
        $this->db->set('paciente_id', $paciente_id);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_ambulatorio_guia');
        $ambulatorio_guia_id = $this->db->insert_id();
        return $ambulatorio_guia_id;
    }

    function autorizarpacientetemp($paciente_id, $ambulatorio_guia_id) {
        try {
            $i = 0;
            $confimado = "";
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            foreach ($_POST['procedimento'] as $procedimento_tuss_id) {
                $z = 0;
                $c = 0;
                $d = 0;
                $e = 0;
                $y = 0;
                $x = 0;
                $w = 0;
                $b = 0;
                $f = 0;
                $g = 0;
                $h = 0;
                $i++;

                foreach ($_POST['qtde'] as $itemnome) {
                    $c++;
                    if ($i == $c) {
                        $qtde = $itemnome;
                        break;
                    }
                }
                foreach ($_POST['valor'] as $itemnome) {
                    $z++;
                    if ($i == $z) {
                        $valor = $itemnome;
                        break;
                    }
                }
                foreach ($_POST['formapamento'] as $itemnome) {
                    $e++;
                    if ($i == $e) {
                        $formapagamento = $itemnome;
                        break;
                    }
                }
                foreach ($_POST['convenio'] as $itemconvenio) {
                    $w++;
                    if ($i == $w) {
                        $convenio = $itemconvenio;
                        $this->db->select('dinheiro');
                        $this->db->from('tb_convenio');
                        $this->db->where("convenio_id", $convenio);
                        $query = $this->db->get();
                        $return = $query->result();
                        $dinheiro = $return[0]->dinheiro;

                        break;
                    }
                }
                foreach ($_POST['autorizacao'] as $itemautorizacao) {
                    $b++;
                    if ($i == $b) {
                        $autorizacao = $itemautorizacao;
                        break;
                    }
                }
                foreach ($_POST['agenda_exames_id'] as $itemagenda_exames_id) {
                    $x++;
                    if ($i == $x) {
                        $agenda_exames_id = $itemagenda_exames_id;
                        break;
                    }
                }
                foreach ($_POST['crm'] as $crm) {
                    $f++;
                    if ($i == $f) {
                        $medico_id = $crm;
                        break;
                    }
                }
                foreach ($_POST['confimado'] as $key => $itemconfimado) {
                    $y++;
                    if ($i == $key) {
                        $confimado = $itemconfimado;
                        break;
                    }
                }
                foreach ($_POST['data'] as $key => $itemdata) {
                    $h++;
                    if ($i == $h) {
                        $entregadata = $itemdata;
                        break;
                    }
                }
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');
                $procedimento_tuss_id = (int) $procedimento_tuss_id;
                $agenda_exames_id = (int) $agenda_exames_id;
                if ($confimado == "on" && $procedimento_tuss_id > 0) {
                    $empresa_id = $this->session->userdata('empresa_id');
                    $this->db->set('empresa_id', $empresa_id);
                    $this->db->set('paciente_id', $paciente_id);
                    $this->db->set('procedimento_tuss_id', $procedimento_tuss_id);
                    $this->db->set('convenio_id', $convenio);
                    if ($entregadata != "") {
                        $this->db->set('data_entrega', $entregadata);
                    }
                    if ($_POST['ordenador'] != "") {
                        $this->db->set('ordenador', $_POST['ordenador']);
                    }

                    $this->db->set('medico_solicitante', $medico_id);
                    $this->db->set('autorizacao', $autorizacao);
                    $this->db->set('guia_id', $ambulatorio_guia_id);
                    $this->db->set('quantidade', $qtde);
                    $this->db->set('valor', $valor);
                    $valortotal = $valor * $qtde;
                    $this->db->set('valor_total', $valortotal);

                    if ($_POST['formapamento'] != 0 && $dinheiro == "t") {
                        $this->db->set('faturado', 't');
                        $this->db->set('forma_pagamento', $formapagamento);
                        $this->db->set('valor1', $valortotal);
                        $this->db->set('operador_faturamento', $operador_id);
                        $this->db->set('data_faturamento', $horario);
                    }
                    $this->db->set('confirmado', 't');

                    $this->db->set('ambulatorio_pacientetemp_id', null);
                    $this->db->set('data_autorizacao', $horario);
                    $this->db->set('operador_autorizacao', $operador_id);
                    $this->db->where('agenda_exames_id', $agenda_exames_id);
                    $this->db->update('tb_agenda_exames');
                    $confimado = "";
                }
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function autorizarpacientetempconsulta($paciente_id, $ambulatorio_guia_id) {
        try {
//            $testemedico = $_POST['medico_id'];
//            var_dump($testemedico);
//            die;
            $i = 0;
            $confimado = "";
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            foreach ($_POST['procedimento'] as $procedimento_tuss_id) {
                $z = 0;
                $c = 0;
                $d = 0;
                $e = 0;
                $y = 0;
                $x = 0;
                $w = 0;
                $b = 0;
                $f = 0;
                $g = 0;
                $h = 0;
                $i++;

                foreach ($_POST['sala'] as $itemnome) {
                    $c++;
                    if ($i == $c) {
                        $sala = $itemnome;
                        break;
                    }
                }
                foreach ($_POST['valor'] as $itemnome) {
                    $z++;
                    if ($i == $z) {
                        $valor = $itemnome;
                        break;
                    }
                }
                foreach ($_POST['formapamento'] as $itemnome) {
                    $e++;
                    if ($i == $e) {
                        $formapagamento = $itemnome;
                        break;
                    }
                }
                foreach ($_POST['convenio'] as $itemconvenio) {
                    $w++;
                    if ($i == $w) {
                        $convenio = $itemconvenio;
                        $this->db->select('dinheiro');
                        $this->db->from('tb_convenio');
                        $this->db->where("convenio_id", $convenio);
                        $query = $this->db->get();
                        $return = $query->result();
                        $dinheiro = $return[0]->dinheiro;

                        break;
                    }
                }
                foreach ($_POST['autorizacao'] as $itemautorizacao) {
                    $b++;
                    if ($i == $b) {
                        $autorizacao = $itemautorizacao;
                        break;
                    }
                }
                foreach ($_POST['agenda_exames_id'] as $itemagenda_exames_id) {
                    $x++;
                    if ($i == $x) {
                        $agenda_exames_id = $itemagenda_exames_id;
                        break;
                    }
                }
                foreach ($_POST['medico_id'] as $crm) {
                    $f++;
                    if ($i == $f) {
                        $medico_id = $crm;
                        break;
                    }
                }
                foreach ($_POST['confimado'] as $key => $itemconfimado) {
                    $y++;
                    if ($i == $key) {
                        $confimado = $itemconfimado;
                        break;
                    }
                }
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');
                $procedimento_tuss_id = (int) $procedimento_tuss_id;
                $agenda_exames_id = (int) $agenda_exames_id;
                if ($confimado == "on" && $procedimento_tuss_id > 0) {
                    $empresa_id = $this->session->userdata('empresa_id');
                    $this->db->set('empresa_id', $empresa_id);
                    $this->db->set('paciente_id', $paciente_id);
                    $this->db->set('procedimento_tuss_id', $procedimento_tuss_id);

                    $this->db->set('convenio_id', $convenio);
                    if ($_POST['ordenador'] != "") {
                        $this->db->set('ordenador', $_POST['ordenador']);
                    }
                    if ($medico_id != "") {
                        $this->db->set('medico_agenda', $medico_id);
                        $this->db->set('medico_consulta_id', $medico_id);
                    }
                    $this->db->set('autorizacao', $autorizacao);
                    $this->db->set('guia_id', $ambulatorio_guia_id);
                    $this->db->set('quantidade', '1');
                    $this->db->set('agenda_exames_nome_id', $sala);
                    $this->db->set('valor', $valor);
                    $this->db->set('valor_total', $valor);
                    if ($_POST['formapamento'] != 0 && $dinheiro == "t") {
                        $this->db->set('faturado', 't');
                        $this->db->set('forma_pagamento', $formapagamento);
                        $this->db->set('valor1', $valortotal);
                        $this->db->set('operador_faturamento', $operador_id);
                        $this->db->set('data_faturamento', $horario);
                    }

                    $this->db->set('confirmado', 't');

                    $this->db->set('ambulatorio_pacientetemp_id', null);
                    $this->db->set('data_autorizacao', $horario);
                    $this->db->set('operador_autorizacao', $operador_id);
                    $this->db->where('agenda_exames_id', $agenda_exames_id);
                    $this->db->update('tb_agenda_exames');
                    $confimado = "";
                }
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function autorizarpacientetempfisioterapia($paciente_id, $ambulatorio_guia_id) {
        try {
//            $testemedico = $_POST['medico_id'];
//            var_dump($testemedico);
//            die;
            $i = 0;
            $confimado = "";
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            foreach ($_POST['procedimento'] as $procedimento_tuss_id) {
                $z = 0;
                $c = 0;
                $d = 0;
                $e = 0;
                $y = 0;
                $x = 0;
                $w = 0;
                $b = 0;
                $f = 0;
                $g = 0;
                $h = 0;
                $j = 0;
                $i++;

                foreach ($_POST['sala'] as $itemnome) {
                    $c++;
                    if ($i == $c) {
                        $sala = $itemnome;
                        break;
                    }
                }
                foreach ($_POST['valor'] as $itemnome) {
                    $z++;
                    if ($i == $z) {
                        $valor = $itemnome;
                        break;
                    }
                }
                foreach ($_POST['formapamento'] as $itemnome) {
                    $e++;
                    if ($i == $e) {
                        $formapagamento = $itemnome;
                        break;
                    }
                }
                foreach ($_POST['convenio'] as $itemconvenio) {
                    $w++;
                    if ($i == $w) {
                        $convenio = $itemconvenio;
                        $this->db->select('dinheiro');
                        $this->db->from('tb_convenio');
                        $this->db->where("convenio_id", $convenio);
                        $query = $this->db->get();
                        $return = $query->result();
                        $dinheiro = $return[0]->dinheiro;
                        break;
                    }
                }
                foreach ($_POST['autorizacao'] as $itemautorizacao) {
                    $b++;
                    if ($i == $b) {
                        $autorizacao = $itemautorizacao;
                        break;
                    }
                }
                foreach ($_POST['qtde'] as $itemqtde) {
                    $j++;
                    if ($i == $j) {
                        $qtde = $itemqtde;
                        break;
                    }
                }
                foreach ($_POST['agenda_exames_id'] as $itemagenda_exames_id) {
                    $x++;
                    if ($i == $x) {
                        $agenda_exames_id = $itemagenda_exames_id;
                        break;
                    }
                }
                foreach ($_POST['medico_id'] as $crm) {
                    $f++;
                    if ($i == $f) {
                        $medico_id = $crm;
                        break;
                    }
                }
                foreach ($_POST['confimado'] as $key => $itemconfimado) {
                    $y++;
                    if ($i == $key) {
                        $confimado = $itemconfimado;
                        break;
                    }
                }
                $horario = date("Y-m-d H:i:s");
                $datahoje = date("Y-m-d");
                $operador_id = $this->session->userdata('operador_id');
                $procedimento_tuss_id = (int) $procedimento_tuss_id;
                $agenda_exames_id = (int) $agenda_exames_id;
                if ($confimado == "on" && $procedimento_tuss_id > 0) {

                    $empresa_id = $this->session->userdata('empresa_id');
                    $this->db->set('empresa_id', $empresa_id);
                    $this->db->set('paciente_id', $paciente_id);
                    $this->db->set('procedimento_tuss_id', $procedimento_tuss_id);

                    $this->db->set('convenio_id', $convenio);
                    if ($_POST['ordenador'] != "") {
                        $this->db->set('ordenador', $_POST['ordenador']);
                    }
                    if ($medico_id != "") {
                        $this->db->set('medico_agenda', $medico_id);
                        $this->db->set('medico_consulta_id', $medico_id);
                    }
                    $this->db->set('autorizacao', $autorizacao);
                    $this->db->set('guia_id', $ambulatorio_guia_id);
                    $this->db->set('quantidade', '1');
                    $this->db->set('agenda_exames_nome_id', $sala);
                    if ($dinheiro == "t") {
                        $this->db->set('valor', $valor);
                        $this->db->set('valor_total', $valor);
                        $this->db->set('confirmado', 't');
                    } else {
                        $this->db->set('valor', $valor);
                        $this->db->set('valor_total', $valor);
                        $this->db->set('confirmado', 't');
                    }
                    $this->db->set('agrupador_fisioterapia', $ambulatorio_guia_id);
                    $this->db->set('numero_sessao', '1');
                    $this->db->set('qtde_sessao', $qtde);
                    if ($formapagamento != 0 && $dinheiro == "t") {
                        $this->db->set('faturado', 't');
                        $this->db->set('forma_pagamento', $formapagamento);
                        $this->db->set('valor1', $valor);
                        $this->db->set('operador_faturamento', $operador_id);
                        $this->db->set('data_faturamento', $horario);
                    }
                    $this->db->set('ativo', 'f');

                    $this->db->set('ambulatorio_pacientetemp_id', null);
                    $this->db->set('data_autorizacao', $horario);
                    $this->db->set('operador_autorizacao', $operador_id);
                    $this->db->where('agenda_exames_id', $agenda_exames_id);
                    $this->db->update('tb_agenda_exames');
                    $confimado = "";
                    for ($index = 2; $index <= $qtde; $index++) {
                        $this->db->set('convenio_id', $convenio);
                        $this->db->set('empresa_id', $empresa_id);
                        $this->db->set('tipo', 'FISIOTERAPIA');
                        if ($_POST['ordenador'] != "") {
                            $this->db->set('ordenador', $_POST['ordenador']);
                        }
                        if ($medico_id != "") {
                            $this->db->set('medico_agenda', $medico_id);
                            $this->db->set('medico_consulta_id', $medico_id);
                        }
                        $this->db->set('autorizacao', $autorizacao);
                        $this->db->set('guia_id', $ambulatorio_guia_id);
                        $this->db->set('quantidade', '1');
                        $this->db->set('agenda_exames_nome_id', $sala);
                        if ($dinheiro == "t") {
                            $this->db->set('valor', 0);
                            $this->db->set('valor_total', 0);
                            $this->db->set('confirmado', 'f');
                        } else {
                            $this->db->set('valor', $valor);
                            $this->db->set('valor_total', $valor);
                            $this->db->set('confirmado', 'f');
                        }
                        $this->db->set('situacao', 'OK');
                        $this->db->set('agrupador_fisioterapia', $ambulatorio_guia_id);
                        $this->db->set('numero_sessao', $index);
                        $this->db->set('qtde_sessao', $qtde);
                        if ($formapagamento != 0 && $dinheiro == "t") {
                            $this->db->set('faturado', 't');
                            $this->db->set('forma_pagamento', $formapagamento);
                            $this->db->set('valor1', $valor);
                            $this->db->set('operador_faturamento', $operador_id);
                            $this->db->set('data_faturamento', $horario);
                        }
                        $this->db->set('ativo', 'f');
                        $this->db->set('data_cadastro', $horario);
                        $this->db->set('operador_cadastro', $operador_id);
                        $this->db->set('procedimento_tuss_id', $procedimento_tuss_id);
                        $this->db->set('paciente_id', $paciente_id);
                        $this->db->set('ambulatorio_pacientetemp_id', null);
                        $this->db->set('data_autorizacao', $horario);
                        $this->db->set('data', $datahoje);
                        $this->db->set('operador_autorizacao', $operador_id);
                        $this->db->insert('tb_agenda_exames');
                        $confimado = "";
                    }
                }
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function verificamedico($crm) {
        $this->db->select();
        $this->db->from('tb_operador');
        $this->db->where('conselho', $crm);
        $this->db->where('medico', 'true');
        $return = $this->db->count_all_results();
        return $return;
    }

    function gravarmedico($crm, $medico) {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->set('conselho', $crm);
        $this->db->set('nome', $medico);
        $this->db->set('medico', 't');
        $this->db->insert('tb_operador');
        $medico_id = $this->db->insert_id();
        return $medico_id;
    }

    function listarmedico($crm) {
        $this->db->select('operador_id');
        $this->db->from('tb_operador');
        $this->db->where('conselho', $crm);
        $this->db->where('medico', 'true');
        $return = $this->db->get();
        return $return->row_array();
    }

    function listarautocompletehorarios($parametro = null, $teste = null) {
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('a.agenda_exames_id,
                            es.nome,
                            o.nome as medico,
                            a.medico_agenda,
                            a.inicio,
                            a.fim,
                            a.data');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = a.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_agenda', 'left');
        $this->db->where('a.ativo', 'true');
        $this->db->where('a.empresa_id', $empresa_id);
        $this->db->where('a.tipo', 'EXAME');
        $this->db->orderby('es.nome');
        $this->db->orderby('a.inicio');
        if ($parametro != null) {
            $this->db->where('es.nome ilike', "%" . $parametro . "%");
            $this->db->where('a.data', $teste);
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarhorariosconsulta($parametro = null, $teste = null) {
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select('a.agenda_exames_id,
                            o.nome as medico,
                            a.inicio,
                            a.data');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_operador o', 'o.operador_id = a.medico_consulta_id');
        $this->db->orderby('a.inicio');
        $this->db->where('a.ativo', 'true');
        $this->db->where('a.tipo', 'CONSULTA');
        $this->db->where('a.empresa_id', $empresa_id);
        if ($parametro != null) {
            $this->db->where('a.medico_consulta_id', $parametro);
            $this->db->where('a.data', $teste);
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteprocedimentostodos($parametro) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.nome as procedimento');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("pc.ativo", 't');
        $this->db->where('pc.convenio_id', $parametro);
        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteprocedimentos($parametro) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.nome as procedimento');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
//        $this->db->where("pt.grupo !=", 'CONSULTA');
        $this->db->where("pc.ativo", 't');
        $this->db->where('pc.convenio_id', $parametro);
        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteprocedimentosconsulta($parametro) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.nome as procedimento');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("pt.grupo", 'CONSULTA');
        $this->db->where("pc.ativo", 't');
        $this->db->where('pc.convenio_id', $parametro);
        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteprocedimentosfisioterapia($parametro) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.nome as procedimento');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("pt.grupo", 'FISIOTERAPIA');
        $this->db->where("pc.ativo", 't');
        $this->db->where('pc.convenio_id', $parametro);
        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteprocedimentosvalor($parametro = null) {
        $this->db->select('pc.valortotal, pt.qtde');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("pc.ativo", 't');
        $this->db->where('pc.procedimento_convenio_id', $parametro);
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompletemodelos($parametro = null) {
        $this->db->select('ambulatorio_modelo_laudo_id,
                            nome,
                            texto');
        $this->db->from('tb_ambulatorio_modelo_laudo');
        $this->db->where('ativo', 'true');
        $this->db->orderby('nome');
        if ($parametro != null) {
            $this->db->where('ambulatorio_modelo_laudo_id', $parametro);
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarmodeloslaudo($procedimento_tuss_id) {
        $this->db->select('aml.ambulatorio_modelo_laudo_id,
                            aml.nome,
                            aml.texto');
        $this->db->from('tb_ambulatorio_modelo_laudo aml');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_tuss_id = aml.procedimento_tuss_id');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id');
        $this->db->where('aml.ativo', 'true');
        $this->db->where('pc.procedimento_convenio_id', $procedimento_tuss_id);
        $this->db->orderby('aml.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompletelinha($parametro = null) {
        $this->db->select('ambulatorio_modelo_linha_id,
                            nome,
                            texto');
        $this->db->from('tb_ambulatorio_modelo_linha');
        $this->db->where('ativo', 'true');
        $this->db->orderby('nome');
        if ($parametro != null) {
            $this->db->where('nome ilike', $parametro);
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarmodeloslinha($procedimento_tuss_id) {
        $this->db->select('aml.ambulatorio_modelo_linha_id,
                            aml.nome,
                            aml.texto');
        $this->db->from('tb_ambulatorio_modelo_linha aml');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_tuss_id = aml.procedimento_tuss_id');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id');
        $this->db->where('aml.ativo', 'true');
        $this->db->where('pc.procedimento_convenio_id', $procedimento_tuss_id);
        $this->db->orderby('aml.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($agenda_exames_id) {

        $this->db->set('ativo', 't');
        $this->db->set('situacao', 'LIVRE');
        $this->db->set('observacoes', "");
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ambulatorio_pacientetemp_id', null);
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('agenda_exames_id', $agenda_exames_id);
        $this->db->update('tb_agenda_exames');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function excluirexametemp($agenda_exames_id) {

        $this->db->set('paciente_id', null);
        $this->db->set('ativo', 't');
        $this->db->set('situacao', 'LIVRE');
        $this->db->set('observacoes', "");
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ambulatorio_pacientetemp_id', null);
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('agenda_exames_id', $agenda_exames_id);
        $this->db->update('tb_agenda_exames');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function criar() {

        $this->db->set('nome', '');
        $this->db->insert('tb_ambulatorio_pacientetemp');
        $ambulatorio_pacientetemp_id = $this->db->insert_id();

        return $ambulatorio_pacientetemp_id;
    }

    function gravar() {
        try {

            /* inicia o mapeamento no banco */
            $procedimento_tuss_id = $_POST['txtprocedimentotussid'];
            $this->db->set('nome', $_POST['txtNome']);
            $this->db->set('tuss_id', $_POST['txtprocedimento']);
            $this->db->set('codigo', $_POST['txtcodigo']);
            $this->db->set('descricao', $_POST['txtdescricao']);

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtprocedimentotussid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_procedimento_tuss');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $procedimento_tuss_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $procedimento_tuss_id = $_POST['txtprocedimentotussid'];
                $this->db->where('procedimento_tuss_id', $procedimento_tuss_id);
                $this->db->update('tb_procedimento_tuss');
            }

            return $servidor_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function excluirpaciente($paciente_id) {
        try {

            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('ativo', 'f');
            $this->db->set('data_exclusao', $horario);
            $this->db->set('operador_exclusao', $operador_id);
            $this->db->where('paciente_id', $paciente_id);
            $this->db->update('tb_paciente');

            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($ambulatorio_pacientetemp_id) {

        if ($ambulatorio_pacientetemp_id != 0) {
            $this->db->select('nome, nascimento, idade, celular, telefone');
            $this->db->from('tb_paciente');
            $this->db->where("paciente_id", $ambulatorio_pacientetemp_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_ambulatorio_pacientetemp_id = $ambulatorio_pacientetemp_id;

            $this->_nome = $return[0]->nome;
            $this->_nascimento = $return[0]->nascimento;
            $this->_idade = $return[0]->idade;
            $this->_celular = $return[0]->celular;
            $this->_telefone = $return[0]->telefone;
        } else {
            $this->_ambulatorio_pacientetemp_id = null;
        }
    }

}

?>
