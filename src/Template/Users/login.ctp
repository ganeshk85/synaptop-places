<div class="users form">
<?php echo $this->Flash->render('auth'); ?>
<?= $this->Form->create(); ?>
    <fieldset>
        <legend>
            Please enter your email and password
        </legend>
        <?= $this->Form->input('email'); ?>
        <?= $this->Form->input('password'); ?>
    </fieldset>
<?= $this->Form->button('Login'); ?>
<?= $this->Form->end(); ?>
</div>