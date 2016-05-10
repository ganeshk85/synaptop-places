<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Place'), ['action' => 'edit', $place->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Place'), ['action' => 'delete', $place->id], ['confirm' => __('Are you sure you want to delete # {0}?', $place->id)]) ?> </li>
        <li><a href="http://synaptop-gkhandare.c9users.io/visittoronto/">List Places</a></li>
        <li><?= $this->Html->link(__('New Place'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="places view large-9 medium-8 columns content">
    <h3><?= h($place->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Title') ?></th>
            <td><?= h($place->title) ?></td>
        </tr>
        <tr>
            <th><?= __('Url') ?></th>
            <td><?= h($place->url) ?></td>
        </tr>
        <tr>
            <th><?= __('Imagesrc') ?></th>
            <td><img src="https://synaptop-gkhandare.c9users.io/visittoronto/webroot/img/places/<?= h($place->imagesrc) ?>" /></td>
        </tr>
        <tr>
            <th><?= __('Description') ?></th>
            <td><?= h($place->description) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($place->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Lng') ?></th>
            <td><?= $this->Number->format($place->lng) ?></td>
        </tr>
        <tr>
            <th><?= __('Lat') ?></th>
            <td><?= $this->Number->format($place->lat) ?></td>
        </tr>
    </table>
</div>
