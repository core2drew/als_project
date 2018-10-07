<div class="modal-container profile">
  <div id="UpdateProfileModal" class="modal profile">
    <div class="title">Update Profile</div>
    <div class="content">
      <form id="UpdateProfileForm" autocomplete="off" class="form" method="POST">
        <div class="input" id="UpdateProfileImage">
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