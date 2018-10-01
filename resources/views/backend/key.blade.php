@extends('backend.layout')
@section('controller')

<div class="container">
  <!--Add buttons to initiate auth sequence and sign out-->
  <button class="btn" id="authorize-button" style="display: none; margin-bottom: 10px">Authorize</button>
  <button class="btn" id="signout-button" style="display: none; margin-bottom: 10px">Sign Out</button>

  <div id="buttons">
    <!-- <form action="" method="post" enctype= "multipart/form-data"> -->
      <div class="form-group">
        <div style="color: red; font-weight: bold; font-size: 20px">
          Bắt buộc phải đăng nhập trước khi Search
          <ul style="color: black; font-size: 20px">
            <li>Hiện nút "Authorize" là bạn chưa đăng nhập!</li>
            <li>Hiện nút "Sign Out" là bạn đã đăng nhập!</li>
            <li>Không hiện nút nào hãy kiểm tra lại thông tin bạn đã điền hoặc bạn chưa thêm tên website <b style='color:red'>http://toolreup.ga</b> lúc tạo Api</li>
          </ul>
        </div>
        <label for="usr">Từ khóa</label>
        <input type="text" value="episode" name="key" class="form-control input" id="query">
        <div class="checkbox">
          <label><input id="checkbox" checked type="checkbox">Tìm kiếm trong tiêu đề bắt buộc có chứa từ khóa</label>
        </div>
        <div class="checkbox">
          <label><input id="order" checked type="checkbox">Tìm theo VIEW cao->thấp (Không tích là tìm theo DATE publish sớm->muộn)</label>
        </div>
        <div class="checkbox">
          <label><input id="videoDuration" checked type="checkbox">Thời lượng video > 20 phút</label>
        </div>
      </div>
      <div class="form-group">
        <label for="usr">Publish từ</label>
        <input id="publish" type="text" value="<?php echo date('Y-m-d').'T'.date('H:i:s').'.000Z'; ?>" class="form-control input pub">
        <label for="usr">Publish đến</label>
        <input id="publish1" type="text" value="<?php echo date('Y-m-d').'T'.date('H:i:s').'.000Z'; ?>" class="form-control input pub">
        <!-- <label>Time Now</label>
        <div id="timenow"></div> -->
       </div>
      <!-- <div class="form-group"><button class="btn" onclick="timenow()">Get Time Now</button></div> -->
      <div class="form-group"><button class="btn" onclick="search()" id="search-button">Search</button></div>
    <!-- </form> -->
  </div>
  <div id="search-container"></div>
  <table class="table table-bordered table-hover" id="table">
    <tr>
      <th style="text-align: center;">STT</th>
      <th style="text-align: center;">Image</th>
      <th style="width: 350px;text-align: center;">Title</th>
      <th style="text-align: center;">View</th>
      <th style="text-align: center; width: 300px">Publish</th>
      <th style="text-align: center;">Video ID</th>
    </tr>
  </table>
  <!-- <span id="result" style="font-size: 20px;font-weight: bold; padding-bottom: 20px;"></span> -->
</div>
<script type="text/javascript">
var CLIENT_ID = '<?php echo $arr->clientID; ?>';

// Array of API discovery doc URLs for APIs used by the quickstart
var DISCOVERY_DOCS = ["https://www.googleapis.com/discovery/v1/apis/youtube/v3/rest"];

// Authorization scopes required by the API. If using multiple scopes,
// separated them with spaces.
var SCOPES = 'https://www.googleapis.com/auth/youtube.force-ssl';

var authorizeButton = document.getElementById('authorize-button');
var signoutButton = document.getElementById('signout-button');

/**
*  On load, called to load the auth2 library and API client library.
*/
function handleClientLoad() {
gapi.load('client:auth2', initClient);
}

/**
*  Initializes the API client library and sets up sign-in state
*  listeners.
*/
function initClient() {
gapi.client.init({
  discoveryDocs: DISCOVERY_DOCS,
  clientId: CLIENT_ID,
  scope: SCOPES
}).then(function () {
  // Listen for sign-in state changes.
  gapi.auth2.getAuthInstance().isSignedIn.listen(updateSigninStatus);

  // Handle the initial sign-in state.
  updateSigninStatus(gapi.auth2.getAuthInstance().isSignedIn.get());
  authorizeButton.onclick = handleAuthClick;
  signoutButton.onclick = handleSignoutClick;
});
}

/**
*  Called when the signed in status changes, to update the UI
*  appropriately. After a sign-in, the API is called.
*/
function updateSigninStatus(isSignedIn) {
	if (isSignedIn) {
	  authorizeButton.style.display = 'none';
	  signoutButton.style.display = 'block';
	  // getChannel();
	} else {
	  authorizeButton.style.display = 'block';
	  signoutButton.style.display = 'none';
	}
}

/**
*  Sign in the user upon button click.
*/
function handleAuthClick(event) {
gapi.auth2.getAuthInstance().signIn();
}

/**
*  Sign out the user upon button click.
*/
function handleSignoutClick(event) {
gapi.auth2.getAuthInstance().signOut();
}

/**
* Append text to a pre element in the body, adding the given message
* to a text node in that element. Used to display info from API response.
*
* @param {string} message Text to be placed in pre element.
*/
function appendPre(message) {
var pre = document.getElementById('content');
var textContent = document.createTextNode(message + '\n');
pre.appendChild(textContent);
}

/**
* Print files.
*/
// function getChannel() {
// gapi.client.youtube.channels.list({
//   'part': 'snippet,contentDetails,statistics',
//   'forUsername': 'GoogleDevelopers'
// }).then(function(response) {
//   var channel = response.result.items[0];
//   appendPre('This channel\'s ID is ' + channel.id + '. ' +
//             'Its title is \'' + channel.snippet.title + ', ' +
//             'and it has ' + channel.statistics.viewCount + ' views.');
// });
// }
</script>
<script async defer src="https://apis.google.com/js/api.js"
  onload="this.onload=function(){};handleClientLoad()"
  onreadystatechange="if (this.readyState === 'complete') this.onload()">
</script>

<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script> -->
<script src="{{ url('public/js/search1.js') }}"></script>
<script src="https://apis.google.com/js/client.js?onload=googleApiClientReady"></script>

@endsection
