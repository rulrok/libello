<?php
namespace app\modelo;
    
require_once 'abstractDAO.php';

class ferramentaDAO extends abstractDAO {

    /**
     * 
     * @param type $ferramentaID
     * @return type
     * @deprecated since version Alpha-1 Os nomes serão recuperados através da classe de enumeração \app\modelo\Ferramenta
     */
    public function obterNomeFerramenta($ferramentaID) {
        $sql = "SELECT nome FROM sistema_ferramenta WHERE idFerramenta = :idFerramenta";
        $params = array(':idFerramenta' => array($ferramentaID, \PDO::PARAM_INT));
        return $this->executarSelect($sql, $params, false);
    }

}

?>  