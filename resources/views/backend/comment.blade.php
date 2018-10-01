@extends('backend.layout')
@section('controller')
<meta charset='utf-8' />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!--Add buttons to initiate auth sequence and sign out-->
<script>

  /***** START BOILERPLATE CODE: Load client library, authorize user. *****/

  // Global variables for GoogleAuth object, auth status.
  var GoogleAuth;

  /**
   * Load the API's client and auth2 modules.
   * Call the initClient function after the modules load.
   */
  function handleClientLoad() {
    gapi.load('client:auth2', initClient);
  }

  function initClient() {
    // Initialize the gapi.client object, which app uses to make API requests.
    // Get API key and client ID from API Console.
    // 'scope' field specifies space-delimited list of access scopes

    gapi.client.init({
        'clientId': '<?php echo $arr->clientID; ?>',
        'discoveryDocs': ['https://www.googleapis.com/discovery/v1/apis/youtube/v3/rest'],
        'scope': 'https://www.googleapis.com/auth/youtube.force-ssl https://www.googleapis.com/auth/youtubepartner'
    }).then(function () {
      GoogleAuth = gapi.auth2.getAuthInstance();

      // Listen for sign-in state changes.
      GoogleAuth.isSignedIn.listen(updateSigninStatus);

      // Handle initial sign-in state. (Determine if user is already signed in.)
      setSigninStatus();

      // Call handleAuthClick function when user clicks on "Authorize" button.
      $('#execute-request-button').click(function() {
        handleAuthClick();
      }); 
    });
  }

  function handleAuthClick() {
    // Sign user in after click on auth button.
    GoogleAuth.signIn();
  }

  function setSigninStatus() {
    var user = GoogleAuth.currentUser.get();
    isAuthorized = user.hasGrantedScopes('https://www.googleapis.com/auth/youtube.force-ssl https://www.googleapis.com/auth/youtubepartner');
    // Toggle button text and displayed statement based on current auth status.
    // if (isAuthorized) {
    //   defineRequest();
    // }
  }

  function updateSigninStatus(isSignedIn) {
    setSigninStatus();
  }

  function createResource(properties) {
    var resource = {};
    var normalizedProps = properties;
    for (var p in properties) {
      var value = properties[p];
      if (p && p.substr(-2, 2) == '[]') {
        var adjustedName = p.replace('[]', '');
        if (value) {
          normalizedProps[adjustedName] = value.split(',');
        }
        delete normalizedProps[p];
      }
    }
    for (var p in normalizedProps) {
      // Leave properties that don't have values out of inserted resource.
      if (normalizedProps.hasOwnProperty(p) && normalizedProps[p]) {
        var propArray = p.split('.');
        var ref = resource;
        for (var pa = 0; pa < propArray.length; pa++) {
          var key = propArray[pa];
          if (pa == propArray.length - 1) {
            ref[key] = normalizedProps[p];
          } else {
            ref = ref[key] = ref[key] || {};
          }
        }
      };
    }
    return resource;
  }

  function removeEmptyParams(params) {
    for (var p in params) {
      if (!params[p] || params[p] == 'undefined') {
        delete params[p];
      }
    }
    return params;
  }

  function executeRequest(request) {
    request.execute(function(response) {
      // console.log(response);
    });
  }

  function buildApiRequest(requestMethod, path, params, properties) {
    params = removeEmptyParams(params);
    var request;
    if (properties) {
      var resource = createResource(properties);
      request = gapi.client.request({
          'body': resource,
          'method': requestMethod,
          'path': path,
          'params': params
      });
    } else {
      request = gapi.client.request({
          'method': requestMethod,
          'path': path,
          'params': params
      });
    }
    executeRequest(request);
  }

  /***** END BOILERPLATE CODE *****/

  
//   function defineRequest() {
//     // See full sample for buildApiRequest() code, which is not 
// // specific to a particular API or API method.

//     buildApiRequest('POST',
//                     '/youtube/v3/comments',
//                     {'part': 'snippet'},
//                     {'snippet.parentId': 'z22xjftxtom4vh0of04t1aokg0t5svg4cx2blaubtp3drk0h00410',
//                      'snippet.textOriginal': 'ok 2'
//           });

//   }
/***** ADD ARRAY *****/
var m=0;
function add(){
  m++;
  $('#table').append("<tr><td style='width: 200px'>Comments random "+m+"</td><td style='width: 500px'><input class='mang_random form-control' size='100%'' type='text' id='mang_random"+m+"'></td></tr>")
}
/***** END ADD ARRAY *****/


/***** LIST COMMNET *****/
var mang = [];
var token,numItems,token1;
function list_commentThreads(){
  videoId = $('#videoId').val();
  numItems = $('.mang_random').length;
  for(n=0;n<numItems;n++){
    mang[n] = $('#mang_random'+n).val();
  }
  
  var arr = gapi.client.youtube.commentThreads.list({
    'part': 'snippet,replies',
    'order':'relevance',
    'maxResults':'5',
    'videoId': videoId
  });
  arr.execute(function(responsearr){
    console.log(responsearr);
    $("#commnet_count").html(responsearr.pageInfo.totalResults);
    for(i=0;i<responsearr.pageInfo.totalResults;i++){
      var x = Math.floor((Math.random() * mang.length) + 0);
      buildApiRequest('POST',
        '/youtube/v3/comments',
        {'part': 'snippet'},
        {'snippet.parentId':responsearr.items[i].id,
         'snippet.textOriginal': mang[x]
      });
      // console.log(i);
      // console.log(mang[x]);
    }
    token=responsearr.nextPageToken;
    comment_nextpage();
  });
}
/***** END LIST COMMNET *****/


/***** COMMENT NEXTPAGE *****/
function comment_nextpage(){
  var arr1 = gapi.client.youtube.commentThreads.list({
    'part': 'snippet,replies',
    'order':'relevance',
    'maxResults':'5',
    'pageToken': token,
    'videoId': videoId
  });
  arr1.execute(function(responsearr1){
    console.log(responsearr1);
    $("#commnet_count").html(responsearr1.pageInfo.totalResults);
    x = Math.floor((Math.random() * mang.length) + 0);
    for(i=0;i<responsearr1.pageInfo.totalResults;i++){
      var x = Math.floor((Math.random() * mang.length) + 0);
      buildApiRequest('POST',
        '/youtube/v3/comments',
        {'part': 'snippet'},
        {'snippet.parentId':responsearr1.items[i].id,
         'snippet.textOriginal': mang[x]
      });
      // console.log("luot 2");
      // console.log(i);
      console.log(mang[x]);
    }
    token=responsearr1.nextPageToken;
    token1=responsearr1.nextPageToken;
    // console.log("token1 "+token1);
    // console.log(responsearr1);
    if (responsearr1.pageInfo.totalResults == responsearr1.pageInfo.resultsPerPage && token1!=undefined) {
      comment_nextpage();
    } else{
      // console.log("DONE");
      alert("Auto Comments Xong!");
    }

  });
}
/***** END COMMENT NEXTPAGE *****/

</script>
    
<div class="container">
  <div><button class="btn" id="execute-request-button">Authorize</button></div>
  <table style="margin-top: 20px; margin-bottom: 20px" id="table">
    <tr>
      <td style="width: 200px">ID video</td>
      <td style="width: 500px"><input type="text" value="" class="form-control" name="" id="videoId"></td>
    </tr>
    <tr>
      <td style="width: 200px">Tổng comment</td>
      <td id="commnet_count"></td>
    </tr>
    <tr>
      <td style="width: 200px">Mảng random</td>
      <td style="width: 500px"><input size="100%" type="text" name="" class="mang_random form-control" id="mang_random0"></td>
    </tr>
    
</table> 
<ul>
  <li>Help me to get 10.000 Subscriber:  Thanks</li>
  <li>Thanks for watching my videos. Subscribe here  to get updated video soon</li>
  <li>Thanks for your comment. Help me get 10.000 Subscriber </li>
  <li>We glad to have you as a subscriber  thank you</li>
  <li>I want to get 10.000 Subscriber. Please help me here </li>
</ul>
  <div><button class="btn" onclick="add()">Add</button><span> </span><button class="btn" onclick="list_commentThreads()">List</button></div>
</div>



<script async defer src="https://apis.google.com/js/api.js"
  onload="this.onload=function(){};handleClientLoad()"
  onreadystatechange="if (this.readyState === 'complete') this.onload()">
</script>

@endsection
