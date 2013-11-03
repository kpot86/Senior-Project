<?php $this->load->view("template_header"); ?>

<?php 
    echo form_open('admin/register_professor', array(
        'class' => 'form-register',
        'id' => 'registration_form'
    ));
?>

<div class="text-center">
    <h4>Create a New Professor User</h4>
</div>
<?php
    //echo form_input('email_address',set_value('email_address'),'id="email_address"');
    echo form_input(array(
                    'id' => 'email_address',
                    'name' => 'email_address',
                    'type' => 'email',
                    'class' => 'input-block-level input-large',
                    'placeholder' => 'email@example.com',
                    'value' => set_value('email_address'),
                    'required' => '',
                    'title' => 'Email address'
                ));

    //echo form_password('password_1','','id="password_1"');
    echo form_password(array(
                    'id' => 'password_1',
                    'name' => 'password_1',
                    'class' => 'input-block-level input-large',
                    'placeholder' => 'Password',
                    'required' => '',
                    'title' => 'Password'
                ));

    //echo form_password('password_2','','id="password_2"');
    echo form_password(array(
                    'id' => 'password_2',
                    'name' => 'password_2',
                    'class' => 'input-block-level input-large',
                    'placeholder' => 'Confirm Password',
                    'required' => '',
                    'title' => 'Password Confirmation',
                    'oninput' => 'pwd_should_match()'
                ));

    /* $data = array(
        'id' => 'btn',
        'class' => 'btn',
        'name' => 'accounts',
        );

     echo form_submit($data,'Create Senior Project Account');
    */
    echo form_submit(array(
        'id' => 'btn',
        'name' => 'accounts',
        'type' => 'Submit',
        'class' => 'btn btn-default',
        'value' => 'Create Professor User'
    ));

    echo form_close() 
?>

<?php 
    echo form_open('admin/activate_deactive_users', array(
        'class' => 'form-register',
        'id' => 'act_deact_form'
    ));
?>
<div class="text-center">
    <h4>Active and Deactivate Users</h4>
</div>
<table class = "table table-striped">
            <tr class="header">
                <td>First Name</td>
                <td>Last Name</td>
                <td>Email</td>
                <td>Role</td>
                <td>Status</td>
                <td>Select</td>
            </tr>
            <?php
            $query = $this->db->query('SELECT id, first_name, last_name, email, role, status FROM spw_user
                WHERE role != "HEAD"
                ORDER BY last_name');
               foreach ($query->result_array() as $row)
                {
                   echo "<tr>";
                   echo "<td>".$row['first_name']."</td>";
                   echo "<td>".$row['last_name']."</td>";
                   echo "<td>".$row['email']."</td>";
                   echo "<td>".$row['role']."</td>";
                   echo "<td>".$row['status']."</td>";
                   echo "<td><input type=\"checkbox\" name=\"users[]\" value=\"" . $row['id']."\"></td>";
                   echo "</tr>";
               }

            ?>
</table>

<?php echo 'Choose an action to apply:'?>

<table>
    <tr>
        <td><?php echo form_radio(array("name"=>"action","id"=>"act","value"=>"Activate", 'checked'=>set_radio('action', 'Activate', TRUE))); ?></td>
        <td><?php echo form_label('Activate', 'act');?></td>
    </tr>
    <tr>
        <td><?php  echo form_radio(array("name"=>"action","id"=>"deact","value"=>"Deactivate", 'checked'=>set_radio('action', 'Deactivate', FALSE))); ?></td>
        <td><?php echo form_label('Deactivate', 'deact');?></td>
    </tr>
</table>
<br>

<?php echo form_submit(array(
        'id' => 'btn-act-deact',
        'name' => 'activate',
        'type' => 'Submit',
        'class' => 'btn btn-default',
        'value' => 'Execute Changes'
  ));
echo form_close()
?>

 <?php $this->load->view("template_footer"); ?>
