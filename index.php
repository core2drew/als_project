<?php
  include 'includes/html/head.php';
  include './login.php';
  if(isset($_SESSION['is_logged_in'])) {
    switch($_SESSION['type']) {
      case 'student':
        header("Location: home.php");
        break;
      case 'teacher':
        header("Location: home.php");
        break;
      case 'coordinator':
        if($_SESSION['is_admin']) {
          header("Location: /coordinator/account.php?page=accounts&sub_page=coordinator&type=coordinator");
         
        } else {
          header("Location: /coordinator/account.php?page=accounts&sub_page=teacher&type=teacher&grade_level=1");
        }
        
        break;
    }
  }
?>
  <div id="LoginWrapper">
    <div id="Header">
      <div class="container">
        <div class="als-logo">
          <img class="img" src="/public/images/als-logo.png"/>
        </div>
        <form id="LoginForm" method="POST" autocomplete="off">
          <div class="field">
            <input class="input" type="text" name="email" placeholder="Email"/>
          </div>
          <div class="field">
            <input class="input" type="password" name="password" placeholder="Password"/>
          </div>
          <?php echo isset($error_fields['login']) ? "<p class='error_message'>$error_fields[login]</p>" : null ?>
          <button class="button" type="submit">Login</button>
        </form>
      </div>
    </div>

    <div id="HeaderImage">
      <img class="img" src="/public/images/tagline.jpg"/>
    </div>
    <h3 class="title">Feature</h3>
    <div id="Features">
      <div class="feature">
        <svg class="icon" height="511pt" viewBox="1 -14 511.99998 511" width="511pt" xmlns="http://www.w3.org/2000/svg">
          <path d="m459.207031 230.105469c0 126.804687-102.796875 229.601562-229.601562 229.601562-126.808594 0-229.605469-102.796875-229.605469-229.601562 0-126.808594 102.796875-229.605469 229.605469-229.605469 126.804687 0 229.601562 102.796875 229.601562 229.605469zm0 0" fill="#fd747f"/>
          <path d="m412.320312 230.105469c0 100.910156-81.804687 182.714843-182.714843 182.714843-100.914063 0-182.71875-81.804687-182.71875-182.714843 0-100.914063 81.804687-182.71875 182.71875-182.71875 100.910156 0 182.714843 81.804687 182.714843 182.71875zm0 0" fill="#efedee"/>
          <path d="m80.882812 230.105469c0-95.179688 72.777344-173.347657 165.71875-181.925781-5.597656-.515626-11.265624-.792969-17-.792969-100.910156 0-182.714843 81.804687-182.714843 182.71875 0 100.910156 81.804687 182.714843 182.714843 182.714843 5.734376 0 11.402344-.277343 17-.792968-92.941406-8.574219-165.71875-86.746094-165.71875-181.921875zm0 0" fill="#d4d4d4"/>
          <path d="m512 368.691406c0 63.429688-51.417969 114.847656-114.847656 114.847656-63.429688 0-114.847656-51.417968-114.847656-114.847656 0-63.425781 51.417968-114.847656 114.847656-114.847656 63.429687 0 114.847656 51.421875 114.847656 114.847656zm0 0" fill="#94d9fd"/>
          <path d="m302.90625 368.691406c0-59.953125 45.945312-109.171875 104.546875-114.382812-3.394531-.300782-6.828125-.464844-10.300781-.464844-63.429688 0-114.847656 51.421875-114.847656 114.847656 0 63.429688 51.417968 114.847656 114.847656 114.847656 3.472656 0 6.90625-.160156 10.300781-.464843-58.601563-5.207031-104.546875-54.425781-104.546875-114.382813zm0 0" fill="#5dc8eb"/>
          <path d="m357.660156 305.1875c20.15625 0 38.921875 13.203125 38.921875 35.269531 0 37.53125-55.082031 49.695313-55.082031 67.765625v4.167969h48.304688c3.824218 0 7.125 4.519531 7.125 9.730469 0 5.210937-3.300782 10.078125-7.125 10.078125h-61.855469c-3.996094 0-9.902344-2.777344-9.902344-7.125v-16.851563c0-27.800781 55.945313-42.570312 55.945313-67.070312 0-7.125-4.691407-15.464844-16.15625-15.464844-8.515626 0-15.464844 4.519531-15.464844 15.292969 0 4.167969-4.34375 8.339843-11.816406 8.339843-5.90625 0-10.25-2.78125-10.25-12.164062 0-19.804688 18.070312-31.96875 37.355468-31.96875zm0 0" fill="#efedee"/>
          <path d="m446.621094 404.574219h-41.703125c-4.339844 0-7.644531-2.957031-7.644531-7.992188 0-1.390625.347656-2.957031 1.21875-4.519531l41.179687-80.96875c2.085937-4.34375 5.90625-5.90625 9.554687-5.90625 3.996094 0 11.292969 3.476562 11.292969 8.6875 0 .871094-.347656 1.910156-.867187 2.953125l-33.359375 66.722656h20.328125v-18.242187c0-5.039063 5.734375-7.125 11.292968-7.125 5.734376 0 11.296876 2.085937 11.296876 7.125v18.242187h8.164062c4.691406 0 7.125 5.210938 7.125 10.597657 0 5.214843-3.476562 10.425781-7.125 10.425781h-8.164062v20.503906c0 4.691406-5.5625 7.125-11.296876 7.125-5.558593 0-11.292968-2.433594-11.292968-7.125zm0 0" fill="#efedee"/>
          <path d="m309.242188 222.378906h-71.914063v-71.914062c0-4.265625-3.457031-7.726563-7.726563-7.726563-4.265624 0-7.726562 3.460938-7.726562 7.726563v79.640625c0 4.265625 3.460938 7.722656 7.726562 7.722656h79.640626c4.265624 0 7.726562-3.457031 7.726562-7.722656 0-4.269531-3.460938-7.726563-7.726562-7.726563zm0 0" fill="#5dc8eb"/>
          <path d="m250.289062 230.105469c0 11.421875-9.261718 20.683593-20.683593 20.683593-11.425781 0-20.6875-9.261718-20.6875-20.683593 0-11.425781 9.261719-20.6875 20.6875-20.6875 11.421875 0 20.683593 9.261719 20.683593 20.6875zm0 0" fill="#fecc2e"/>
          <path d="m246.390625 153.015625-11.96875-23.941406c-1.984375-3.96875-7.652344-3.96875-9.636719 0l-11.96875 23.941406c-1.792968 3.578125.8125 7.792969 4.816406 7.792969h23.941407c4.003906 0 6.609375-4.214844 4.816406-7.792969zm0 0" fill="#fd747f"/>
          <g fill="#5dc8eb">
          <path d="m229.605469 47.386719c-2.589844 0-5.164063.066406-7.726563.175781v44.46875c0 4.265625 3.457032 7.726562 7.726563 7.726562 4.265625 0 7.722656-3.460937 7.722656-7.726562v-44.472656c-2.5625-.105469-5.136719-.171875-7.722656-.171875zm0 0"/>
          <path d="m353.21875 95.5625-31.445312 31.445312c-3.019532 3.019532-3.019532 7.910157 0 10.925782 1.507812 1.507812 3.484374 2.265625 5.460937 2.265625 1.980469 0 3.957031-.753907 5.464844-2.265625l31.445312-31.445313c-3.484375-3.792969-7.132812-7.441406-10.925781-10.925781zm0 0"/>
          <path d="m359.949219 230.105469c0 4.265625 3.457031 7.722656 7.726562 7.722656h44.472657c.105468-2.5625.171874-5.132813.171874-7.722656 0-2.589844-.066406-5.164063-.171874-7.726563h-44.472657c-4.269531 0-7.726562 3.457032-7.726562 7.726563zm0 0"/>
          <path d="m229.601562 360.449219c-4.265624 0-7.726562 3.460937-7.726562 7.726562v44.472657c2.5625.105468 5.140625.171874 7.726562.171874 2.589844 0 5.164063-.066406 7.726563-.171874v-44.472657c0-4.265625-3.457031-7.726562-7.726563-7.726562zm0 0"/>
          <path d="m126.507812 322.273438-31.449218 31.445312c3.488281 3.792969 7.132812 7.441406 10.929687 10.925781l31.445313-31.445312c3.019531-3.019531 3.019531-7.910157 0-10.925781-3.015625-3.019532-7.90625-3.019532-10.925782 0zm0 0"/>
          <path d="m47.058594 237.828125h44.472656c4.265625 0 7.726562-3.457031 7.726562-7.722656 0-4.269531-3.460937-7.726563-7.726562-7.726563h-44.472656c-.105469 2.5625-.171875 5.136719-.171875 7.726563 0 2.589843.066406 5.160156.171875 7.722656zm0 0"/>
          <path d="m95.0625 106.488281 31.445312 31.445313c1.507813 1.511718 3.484376 2.265625 5.464844 2.265625 1.976563 0 3.953125-.753907 5.460938-2.265625 3.019531-3.015625 3.019531-7.90625 0-10.925782l-31.445313-31.445312c-3.792969 3.484375-7.441406 7.132812-10.925781 10.925781zm0 0"/>
          </g>
          <path d="m306.691406 246.890625 23.941406-11.96875c3.96875-1.984375 3.96875-7.652344 0-9.636719l-23.941406-11.96875c-3.578125-1.792968-7.792968.8125-7.792968 4.816406v23.941407c0 4.003906 4.214843 6.609375 7.792968 4.816406zm0 0" fill="#fd747f"/>
        </svg>
        <div class="details">
          <h3 class="title">Any Time</h3>
          <p class="description">
            Learn through the use of technology on the topics provided by the website. Then test yourself with the assessment given by your teacher.
          </p>
        </div>
      </div>
      <div class="feature">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" height="512pt" version="1.1" viewBox="-91 0 512 512" width="512pt">
          <g id="surface1">
            <path d="M 330 91 L 330 302 L 300 332 L 120 332 L 90 302 L 90 91 L 120 60 L 300 60 Z M 330 91 " style=" stroke:none;fill-rule:nonzero;fill:rgb(24.313725%,34.901961%,34.901961%);fill-opacity:1;" />
            <path d="M 330 91 L 330 302 L 300 332 L 210 332 L 210 60 L 300 60 Z M 330 91 " style=" stroke:none;fill-rule:nonzero;fill:rgb(21.960784%,28.627451%,28.627451%);fill-opacity:1;" />
            <path d="M 120 60 L 300 60 L 300 332 L 120 332 Z M 120 60 " style=" stroke:none;fill-rule:nonzero;fill:rgb(77.254902%,100%,80.392157%);fill-opacity:1;" />
            <path d="M 210 60 L 300 60 L 300 332 L 210 332 Z M 210 60 " style=" stroke:none;fill-rule:nonzero;fill:rgb(65.098039%,100%,70.980392%);fill-opacity:1;" />
            <path d="M 330 45 L 330 91 L 90 91 L 90 45 C 90 20.097656 110.097656 0 135 0 L 285 0 C 309.902344 0 330 20.097656 330 45 Z M 330 45 " style=" stroke:none;fill-rule:nonzero;fill:rgb(24.313725%,34.901961%,34.901961%);fill-opacity:1;" />
            <path d="M 330 45 L 330 91 L 210 91 L 210 0 L 285 0 C 309.902344 0 330 20.097656 330 45 Z M 330 45 " style=" stroke:none;fill-rule:nonzero;fill:rgb(21.960784%,28.627451%,28.627451%);fill-opacity:1;" />
            <path d="M 330 302 L 330 347 C 330 371.902344 309.902344 392 285 392 L 135 392 C 110.097656 392 90 371.902344 90 347 L 90 302 Z M 330 302 " style=" stroke:none;fill-rule:nonzero;fill:rgb(24.313725%,34.901961%,34.901961%);fill-opacity:1;" />
            <path d="M 210 302 L 210 392 L 285 392 C 309.902344 392 330 371.902344 330 347 L 330 302 Z M 210 302 " style=" stroke:none;fill-rule:nonzero;fill:rgb(21.960784%,28.627451%,28.627451%);fill-opacity:1;" />
            <path d="M 206.699219 315.5 L 138.601562 452 L 135.300781 450.5 L 51.300781 450.5 C 47.398438 452.300781 42.898438 452.300781 39 450.5 L 33.300781 450.5 L 30 452 L 3.300781 398.300781 C 1.199219 394.101562 0 389.601562 0 384.800781 L 0 239.300781 C 0 227.300781 4.800781 216.199219 13.199219 207.5 L 90 130.699219 L 90 332 L 123.898438 332 L 155.097656 285.5 C 162.898438 273.199219 179.699219 267.800781 194.097656 275.597656 C 208.199219 283.101562 214.199219 300.800781 206.699219 315.5 Z M 206.699219 315.5 " style=" stroke:none;fill-rule:nonzero;fill:rgb(100%,80.784314%,74.901961%);fill-opacity:1;" />
            <path d="M 206.699219 315.5 L 138.601562 452 L 135.300781 450.5 L 90 450.5 L 90 332 L 123.898438 332 L 155.097656 285.5 C 162.898438 273.199219 179.699219 267.800781 194.097656 275.597656 C 208.199219 283.101562 214.199219 300.800781 206.699219 315.5 Z M 206.699219 315.5 " style=" stroke:none;fill-rule:nonzero;fill:rgb(100%,74.901961%,67.058824%);fill-opacity:1;" />
            <path d="M 135 422 L 45 422 C 20.097656 422 0 442.097656 0 467 L 0 497 C 0 505.398438 6.597656 512 15 512 L 165 512 C 173.402344 512 180 505.398438 180 497 L 180 467 C 180 442.097656 159.902344 422 135 422 Z M 135 422 " style=" stroke:none;fill-rule:nonzero;fill:rgb(29.019608%,41.176471%,43.529412%);fill-opacity:1;" />
            <path d="M 180 467 L 180 497 C 180 505.398438 173.402344 512 165 512 L 90 512 L 90 422 L 135 422 C 159.902344 422 180 442.097656 180 467 Z M 180 467 " style=" stroke:none;fill-rule:nonzero;fill:rgb(24.313725%,34.901961%,34.901961%);fill-opacity:1;" />
          </g>
        </svg>
        <div class="details">
          <h3 class="title">Any Where</h3>
          <p class="description">
            To supplement your learning from  ALS, learn through educational videos, teaching modules, and  handout reviewer loaded throughout the various subjects. 
          </p>
        </div>
      </div>
    </div>
    <h3 class="title">About Us</h3>
    <div id="AboutUs">
      <div class="content">
        <img class="img" src="/public/images/school-logo.png" width="100px"/>
        <p class="description">
          Felipe Calderon Elementary School is a central public school 
          in Tanza, Cavite. It was founded in 1904 under the name Tanza 
          Elementary School. The school accommodates Nursery, 
          Preparatory, Elementary and Alternative Learning System Program.
        </p>
      </div>
       <div class="content">
        <img class="img" src="/public/images/als-logo-2.png" width="100px"/>
        <p class="description">
          The Alternative Learning System (ALS) is a 
          free education program implemented by the department of education. 
          It is a parallel learning system that provides a practical option 
          to the existing formal instruction.
        </p>
      </div>
    </div>
    <div id="ContactUs">
      <div class="content">
        <svg version="1.1" class="icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
          <g>
            <g>
              <polygon style="fill:#E6BE94;" points="487.781,484 23.781,484 23.781,268 119.782,268 255.781,132 391.784,268 487.781,268 		"/>
            </g>
            <g>
              <rect x="207.781" y="388" style="fill:#996459;" width="96" height="96"/>
            </g>
            <g>
              <path style="fill:#4BB9EC;" d="M301.781,356h-92c-1.105,0-2,0.895-2,2v30h96v-30C303.781,356.895,302.886,356,301.781,356z"/>
            </g>
            <g>
              <path style="fill:#FF4F19;" d="M329.617,68l13.039-19.562c1.633-2.453,1.789-5.609,0.398-8.211S338.953,36,336,36h-80
                c-4.422,0-8,3.578-8,8v48c0,4.422,3.578,8,8,8h80c2.953,0,5.664-1.625,7.055-4.227s1.234-5.758-0.398-8.211L329.617,68z"/>
            </g>
            <g>
              <g>
                <path style="fill:#5C546A;" d="M256,140c-4.422,0-8-3.578-8-8V28c0-4.422,3.578-8,8-8s8,3.578,8,8v104
                  C264,136.422,260.422,140,256,140z"/>
              </g>
            </g>
            <g>
              <path style="fill:#FF4F19;" d="M288.391,168.938c1.234-2.992,4.156-4.938,7.391-4.938h152c2.734,0,5.281,1.398,6.75,3.703l56,88
                c1.57,2.469,1.664,5.586,0.266,8.148c-1.406,2.555-4.094,4.148-7.016,4.148h-120c-2.125,0-4.156-0.844-5.656-2.344l-88-88
                C287.836,175.367,287.148,171.93,288.391,168.938z"/>
            </g>
            <g>
              <path style="fill:#FF4F19;" d="M223.391,168.938C222.156,165.945,219.234,164,216,164H64c-2.734,0-5.281,1.398-6.75,3.703l-56,88
                c-1.57,2.469-1.664,5.586-0.266,8.148C2.391,266.406,5.078,268,8,268h120c2.125,0,4.156-0.844,5.656-2.344l88-88
                C223.945,175.367,224.633,171.93,223.391,168.938z"/>
            </g>
            <g>
              <g>
                <path style="fill:#E3001E;" d="M391.891,275.891c-2.047,0-4.094-0.781-5.656-2.344L256,143.313L125.766,273.547
                  c-3.125,3.125-8.188,3.125-11.313,0s-3.125-8.188,0-11.313l135.891-135.891c3.125-3.125,8.188-3.125,11.313,0l135.891,135.891
                  c3.125,3.125,3.125,8.188,0,11.313C395.984,275.109,393.938,275.891,391.891,275.891z"/>
              </g>
            </g>
            <g>
              <circle style="fill:#FFEBB7;" cx="256.001" cy="268" r="48"/>
            </g>
            <g>
              <path style="fill:#5C546A;" d="M256,236c-4.422,0-8,3.578-8,8v16h-16c-4.422,0-8,3.578-8,8s3.578,8,8,8h24c4.422,0,8-3.578,8-8
                v-24C264,239.578,260.422,236,256,236z"/>
            </g>
            <g>
              <g>
                <path style="fill:#4BB9EC;" d="M375.781,320c0-11.046-8.954-20-20-20s-20,8.954-20,20c0,1.37,0.141,2.707,0.403,4h-0.403v32h40
                  v-32h-0.403C375.641,322.707,375.781,321.37,375.781,320z"/>
              </g>
              <g>
                <path style="fill:#7E5C62;" d="M356,292c-15.438,0-28,12.562-28,28v36c0,4.422,3.578,8,8,8h40c4.422,0,8-3.578,8-8v-36
                  C384,304.562,371.438,292,356,292z M356,308c6.617,0,12,5.383,12,12v4h-24v-4C344,313.383,349.383,308,356,308z M344,348v-8h24v8
                  H344z"/>
              </g>
            </g>
            <g>
              <g>
                <rect x="136.001" y="396" style="fill:#4BB9EC;" width="40" height="48"/>
              </g>
              <g>
                <path style="fill:#7E5C62;" d="M176,388h-40c-4.422,0-8,3.578-8,8v48c0,4.422,3.578,8,8,8h40c4.422,0,8-3.578,8-8v-48
                  C184,391.578,180.422,388,176,388z M168,404v8h-24v-8H168z M144,436v-8h24v8H144z"/>
              </g>
            </g>
            <g>
              <g>
                <rect x="63.782" y="396" style="fill:#4BB9EC;" width="40" height="48"/>
              </g>
              <g>
                <path style="fill:#7E5C62;" d="M103.781,388h-40c-4.422,0-8,3.578-8,8v48c0,4.422,3.578,8,8,8h40c4.422,0,8-3.578,8-8v-48
                  C111.781,391.578,108.203,388,103.781,388z M95.781,404v8h-24v-8H95.781z M71.781,436v-8h24v8H71.781z"/>
              </g>
            </g>
            <g>
              <g>
                <rect x="408" y="396" style="fill:#4BB9EC;" width="40" height="48"/>
              </g>
              <g>
                <path style="fill:#7E5C62;" d="M448,388h-40c-4.422,0-8,3.578-8,8v48c0,4.422,3.578,8,8,8h40c4.422,0,8-3.578,8-8v-48
                  C456,391.578,452.422,388,448,388z M440,404v8h-24v-8H440z M416,436v-8h24v8H416z"/>
              </g>
            </g>
            <g>
              <g>
                <rect x="335.782" y="396" style="fill:#4BB9EC;" width="40" height="48"/>
              </g>
              <g>
                <path style="fill:#7E5C62;" d="M375.781,388h-40c-4.422,0-8,3.578-8,8v48c0,4.422,3.578,8,8,8h40c4.422,0,8-3.578,8-8v-48
                  C383.781,391.578,380.203,388,375.781,388z M367.781,404v8h-24v-8H367.781z M343.781,436v-8h24v8H343.781z"/>
              </g>
            </g>
            <g>
              <g>
                <path style="fill:#4BB9EC;" d="M447.563,320c0-11.046-8.954-20-20-20s-20,8.954-20,20c0,1.37,0.141,2.707,0.403,4h-0.403v32h40
                  v-32h-0.403C447.422,322.707,447.563,321.37,447.563,320z"/>
              </g>
              <g>
                <path style="fill:#7E5C62;" d="M427.781,292c-15.438,0-28,12.562-28,28v36c0,4.422,3.578,8,8,8h40c4.422,0,8-3.578,8-8v-36
                  C455.781,304.562,443.219,292,427.781,292z M427.781,308c6.617,0,12,5.383,12,12v4h-24v-4
                  C415.781,313.383,421.164,308,427.781,308z M415.781,348v-8h24v8H415.781z"/>
              </g>
            </g>
            <g>
              <g>
                <path style="fill:#4BB9EC;" d="M103.563,320c0-11.046-8.954-20-20-20s-20,8.954-20,20c0,1.37,0.141,2.707,0.403,4h-0.403v32h40
                  v-32h-0.403C103.422,322.707,103.563,321.37,103.563,320z"/>
              </g>
              <g>
                <path style="fill:#7E5C62;" d="M83.781,292c-15.438,0-28,12.562-28,28v36c0,4.422,3.578,8,8,8h40c4.422,0,8-3.578,8-8v-36
                  C111.781,304.562,99.219,292,83.781,292z M83.781,308c6.617,0,12,5.383,12,12v4h-24v-4C71.781,313.383,77.164,308,83.781,308z
                  M71.781,348v-8h24v8H71.781z"/>
              </g>
            </g>
            <g>
              <g>
                <path style="fill:#4BB9EC;" d="M175.344,320c0-11.046-8.954-20-20-20s-20,8.954-20,20c0,1.37,0.141,2.707,0.403,4h-0.403v32h40
                  v-32h-0.403C175.203,322.707,175.344,321.37,175.344,320z"/>
              </g>
              <g>
                <path style="fill:#7E5C62;" d="M155.563,292c-15.438,0-28,12.562-28,28v36c0,4.422,3.578,8,8,8h40c4.422,0,8-3.578,8-8v-36
                  C183.563,304.562,171,292,155.563,292z M155.563,308c6.617,0,12,5.383,12,12v4h-24v-4C143.563,313.383,148.945,308,155.563,308z
                  M143.563,348v-8h24v8H143.563z"/>
              </g>
            </g>
            <g>
              <path style="fill:#7E5C62;" d="M256,324c-30.879,0-56-25.121-56-56s25.121-56,56-56s56,25.121,56,56S286.879,324,256,324z
                M256,228c-22.055,0-40,17.943-40,40s17.945,40,40,40s40-17.943,40-40S278.055,228,256,228z"/>
            </g>
            <g>
              <path style="fill:#7E5C62;" d="M288,348h-64c-13.234,0-24,10.766-24,24v112c0,4.422,3.578,8,8,8s8-3.578,8-8v-88h31.781v88h16v-88
                H296v88c0,4.422,3.578,8,8,8s8-3.578,8-8V372C312,358.766,301.234,348,288,348z M296,380h-80v-8c0-4.414,3.586-8,8-8h64
                c4.414,0,8,3.586,8,8V380z"/>
            </g>
            <g>
              <g>
                <path style="fill:#5C546A;" d="M504,492H8c-4.422,0-8-3.578-8-8s3.578-8,8-8h496c4.422,0,8,3.578,8,8S508.422,492,504,492z"/>
              </g>
            </g>
          </g>
        </svg>
        <div class="details">
          <h3 class="title">School Address</h3>
          <p class="description">San Agustin, Tanza, Cavite</p>
        </div>
      </div>

      <div class="content">
       <svg version="1.1" class="icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
            viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
          <circle style="fill:#6AAF50;" cx="256" cy="256" r="256"/>
          <path style="fill:#4D8538;" d="M135.693,102.206l-0.008,0.004c-29.639,15.464-42.074,51.222-28.494,81.77
            c19.547,43.975,45.793,84.198,77.468,119.423l23.939,23.939l159.073,159.073c39.82-19.335,73.863-48.69,98.876-84.783
            l-58.697-58.697c-2.262-3.334-5.169-6.299-8.681-8.681L177.747,112.833C168.453,99.138,150.365,94.55,135.693,102.206z"/>
          <path style="fill:#FFFFFF;" d="M349.593,300.614c-8.192-5.559-18.954-5.531-27.116,0.071l-11.752,8.066
            c-13.09,8.984-30.498,8.496-43.08-1.187c-11.858-9.127-23.176-18.913-33.924-29.283c-10.371-10.748-20.156-22.065-29.283-33.924
            c-9.684-12.581-10.171-29.989-1.187-43.08l8.066-11.752c5.601-8.162,5.63-18.924,0.071-27.116l-33.64-49.575
            c-9.293-13.694-27.381-18.282-42.054-10.627l-0.009,0.004c-29.639,15.464-42.074,51.222-28.494,81.77
            c19.547,43.975,45.793,84.198,77.468,119.423l23.939,23.939c35.226,31.674,75.449,57.921,119.423,77.468
            c30.549,13.58,66.306,1.145,81.77-28.494l0.004-0.009c7.655-14.672,3.068-32.761-10.627-42.054L349.593,300.614z"/>
        </svg>
        <div class="details">
          <h3 class="title">Contact Number</h3>
          <p class="description">(046) 437 7828</p>
        </div>
      </div>
    </div>
  </div>
<?php
  include 'includes/html/footer.php';
?>