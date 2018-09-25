<div class="modal-container">
  <div id="DeleteModal" class="modal">
    <div class="title">Confirmation</div>
    <div class="content">Are you sure you want to delete this user?</div>
    <div class="actions">
      <span class="action button yes">Yes</span>
      <span class="action button close">No</span>
    </div>
  </div>

  <div id="CreateModal" class="modal account">
    <div class="title">Create Account</div>
    <div class="content">
      <form id="CreateForm" autocomplete="off" class="form" method="POST">
        <input type="hidden" name="grade_level" value="<?php echo $grade_level ?>" />
        <input type="hidden" name="type" value="<?php echo $type ?>" />
        <div class="input" id="ProfileImage">
          <img class="image" src="/public/images/profile-placeholder-image.png" />
          <input type="file" name="profile_image" accept="image/*" />
          <span class="button choose-image">Choose Image</span>
        </div>
        <div class="input">
          <input type="text" name="lastname" placeholder="Last name" required/>
        </div>
        <div class="input">
          <input type="text" name="firstname" placeholder="First name" required />
        </div>
        <div class="input">
          <input type="text" name="address" placeholder="Address" required />
        </div>
        <div class="input">
          <input type="text" name="contactno" placeholder="Contact No." required />
        </div>
        <?php if($type == 'student'): ?>
          <div class="input">
            <select name="teacher_id">
              <option value='' selected>Select Teacher</option>
              <?php
                $teachers_query = "SELECT
                teacher.id, CONCAT(teacher.lastname, ', ', teacher.firstname) as name 
                FROM users teacher WHERE teacher.type = 'teacher' AND teacher.grade_level=$grade_level AND teacher.deleted_at IS NULL";
                $teachers_result = mysqli_query($conn, $teachers_query);
                $teachers_count = mysqli_num_rows($teachers_result);
                if($teachers_count > 0) {
                  while($teacher_row = mysqli_fetch_array($teachers_result, MYSQLI_ASSOC)) {
                    echo "<option value='$teacher_row[id]'>$teacher_row[name]</option>";
                  }
                }
              ?>
            </select>
          </div>
        <?php endif; ?>
        <div class="input">
          <input type="text" name="email" placeholder="Email" required />
        </div>
        <div class="input">
          <input type="password" name="password" placeholder = "Password" required/>
          <span class="button show-password">Show Password</span>
        </div>
      </form>
    </div>
    <div class="actions">
      <span class="action button create">Create</span>
      <span class="action button close">Cancel</span>
    </div>
  </div>

  <div id="UpdateModal" class="modal account">
    <div class="title">Update Account</div>
    <div class="content">
      <form id="UpdateForm" autocomplete="off" class="form" method="POST">
        <div class="input" id="ProfileImage">
          <img class="image" src="/public/images/profile-placeholder-image.png" />
          <input type="file" name="profile_image" accept="image/*" />
          <span class="button choose-image">Choose Image</span>
        </div>
        <div class="input">
          <input type="text" name="lastname" placeholder="Last name" required/>
        </div>
        <div class="input">
          <input type="text" name="firstname" placeholder="First name" required />
        </div>
        <div class="input">
          <input type="text" name="address" placeholder="Address" required />
        </div>
        <div class="input">
          <input type="text" name="contactno" placeholder="Contact No." required />
        </div>
        <?php if($type == 'student'): ?>
          <div class="input">
            <select name="teacher_id">
              <option value='' selected>Select Teacher</option>
              <?php
                $teachers_query = "SELECT
                teacher.id, CONCAT(teacher.lastname, ', ', teacher.firstname) as name 
                FROM users teacher WHERE teacher.type = 'teacher' AND teacher.grade_level=$grade_level AND teacher.deleted_at IS NULL";
                $teachers_result = mysqli_query($conn, $teachers_query);
                $teachers_count = mysqli_num_rows($teachers_result);
                if($teachers_count > 0) {
                  while($teacher_row = mysqli_fetch_array($teachers_result, MYSQLI_ASSOC)) {
                    echo "<option value='$teacher_row[id]'>$teacher_row[name]</option>";
                  }
                }
              ?>
            </select>
          </div>
        <?php endif; ?>
        <div class="input">
          <input type="text" name="email" placeholder="Email" required />
        </div>
        <div class="input">
          <input type="password" name="password" placeholder = "Password" required/>
          <span class="button show-password">Show Password</span>
        </div>
      </form>
    </div>
    <div class="actions">
      <span class="action button update">Update</span>
      <span class="action button close">Cancel</span>
    </div>
  </div>
</div>