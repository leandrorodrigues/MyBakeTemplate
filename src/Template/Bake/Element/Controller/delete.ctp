<%
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
%>

    /**
     * Deletar
     *
     * @param string|null $id id de <%= $singularHumanName %>.
     * @return void Redireciona pro index.
     * @throws \Cake\Network\Exception\NotFoundException Quando o id não é encontrado.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $<%= $singularName %> = $this-><%= $currentModelName %>->get($id);
        if ($this-><%= $currentModelName; %>->delete($<%= $singularName %>)) {
            $this->Flash->success(__('<%= ucfirst($singularHumanName) %> foi excluído(a) com sucesso.'));
        } else {
            $this->Flash->error(__('<%= ucfirst($singularHumanName) %> não pôde ser excluído(a). Tente novamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }
