<%
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * Slightly modified by Òscar Casajuana for the twbs-cake-plugin
 * also under the MIT license.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Utility\Inflector;
use MyBakeTemplate\Core\TemplateCore;

$templateCore = new TemplateCore($schema, $fields, $associations);

$fields = $templateCore->filterListFields();
%>


<div class="<%= $pluralVar %> index">
    <?php echo $this->Html->link(__('Cadastrar novo ') . __('<%=$templateCore->adjustTerm($singularVar)%>'), array('action' => 'add'), array('class' => 'btn btn-primary pull-right')); ?>
    <h1><?=__('<%= ucfirst($templateCore->adjustTerm($pluralVar)) %>')?></h1>

    <div class="well well-sm text-right">
        <?=$this->Form->create(null, ['class' => 'form-inline', 'type' => 'get']) ?>
        <?=
            $this->Form->input('q', ['label' => false, 'placeholder' => __('Busca'), 'class' => 'pull-right', 'append' =>
                $this->Form->button('<span class="fa fa-search"></span>', ['class' => 'btn-primary'])
            ])
        ?>

        <?=$this->Form->end(); ?>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
        <thead>
            <tr>
    <% foreach ($fields as $field){ %>
            <th><?= $this->Paginator->sort('<%= $field %>', '<%= ucfirst($templateCore->adjustTerm($field))  %>') ?></th>
    <% } %>
            <th class="actions">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($<%= $pluralVar %> as $<%= $singularVar %>) { ?>
            <tr>
<%
    foreach ($fields as $field) {
        $type = $templateCore->getFieldType($field);

        switch($type) {
            case 'number':
%>
                <td><?= $this->Number->format($<%= $singularVar %>-><%= $field %>) ?></td>
<%
                break;
            case 'boolean':
%>
                <td><?= $<%= $singularVar %>-><%= $field %>? 'Sim':'Não' ?></td>
<%
                break;
            default:
%>
                <td><?= h($<%= $singularVar %>-><%= $field %>) ?></td>
<%
        }

    }


//TODO: belongsto
/*
<td>
    <?= $<%= $singularVar %>->has('<%= $details['property'] %>') ? $this->Html->link($<%= $singularVar %>-><%= $details['property'] %>-><%= $details['displayField'] %>, ['controller' => '<%= $details['controller'] %>', 'action' => 'view', $<%= $singularVar %>-><%= $details['property'] %>-><%= $details['primaryKey'][0] %>]) : '' ?>
</td>
*/
    $pk = '$' . $singularVar . '->' . $primaryKey[0];
%>
                <td class="actions">
                    <?= $this->Html->link('<span class="fa fa-eye"></span><span class="sr-only">' . __('Visualizar') . '</span>', ['action' => 'view', <%= $pk %>], ['escape' => false, 'class' => 'btn btn-sm btn-primary', 'title' => __('View')]) ?>
                    <?= $this->Html->link('<span class="fa fa-edit"></span><span class="sr-only">' . __('Editar') . '</span>', ['action' => 'edit', <%= $pk %>], ['escape' => false, 'class' => 'btn btn-sm btn-warning', 'title' => __('Edit')]) ?>
                    <?= $this->Form->postLink('<span class="fa fa-trash"></span><span class="sr-only">' . __('Remover') . '</span>', ['action' => 'delete', <%= $pk %>], ['confirm' => __('Deseja realmente remover o ítem #{0}?', <%= $pk %>), 'escape' => false, 'class' => 'btn btn-sm btn-danger', 'title' => __('Delete')]) ?>
                </td>
            </tr>

        <?php }  ?>
        </tbody>
        </table>
    </div>
    <div class="paginator">
        <p class="pull-left"><?= $this->Paginator->counter('Página {{page}} de {{pages}}, mostrando {{current}} registros de {{count}}.') ?></p>
        <ul class="pagination pull-right">
            <?= $this->Paginator->prev('<span class="fa fa-angle-left"></span>', ['escape' => false, 'title' => _('Anterior')]) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next('<span class="fa fa-angle-right"></span>', ['escape' => false, 'title' => _('Próxima')]) ?>
        </ul>
    </div>
</div>
