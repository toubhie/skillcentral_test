<!DOCTYPE html>
<head>
    <title><?php echo get_phrase('live_class'); ?> : <?php echo $course_details['title']; ?></title>
    <meta charset="utf-8" />
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.7.7/css/bootstrap.css"/>
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.7.7/css/react-select.css"/>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link name="favicon" type="image/x-icon" href="<?php echo base_url().'uploads/system/favicon.png' ?>" rel="shortcut icon" />
</head>
<body>
<style>
    body {
        padding-top: 50px;
    }
    .course_info {
        color: #999999;
        font-size: 11px;
        padding-bottom: 10px;
    }
    .btn-finish {
        background-color: #656565;
        border-color: #222222;
        color: #cacaca;
    }
    .btn-finish:hover,
    .btn-finish:focus,
    .btn-finish:active,
    .btn-finish.active,
    .open .dropdown-toggle.btn-finish {
      color: #cacaca;
    }
    .course_user_info{
        color: #989898;
        font-size: 12px;
        margin-right: 20px;
    }
</style>

<!--
<nav id="nav-tool" class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header" style="padding: 0px !important;">
            <a class="navbar-brand" href="#">
                <img src="<?php echo base_url();?>uploads/system/favicon.png" style="height: 25px;" />
                <?php echo get_phrase('live_class'); ?> : <?php echo $course_details['title']; ?>
            </a>


        </div>
        <div id="navbar">
            <form class="navbar-form navbar-right" id="meeting_form">
                <div class="form-group">
                    <div class="course_user_info">
                        <?php echo get_phrase('instructor'); ?> : <?php echo $instructor_details['first_name'].' '.$instructor_details['last_name']; ?>
                    </div>
                    <div class="course_user_info">
                        <?php echo get_phrase('total_enrolment'); ?> : <?php echo $this->crud_model->enrol_history($course_details['id'])->num_rows(); ?>
                    </div>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-finish" onclick="stop_zoom()">
                        <svg style="height:20px; vertical-align: middle;" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="times" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="svg-inline--fa fa-times fa-w-10 fa-3x"><path fill="currentColor" d="M193.94 256L296.5 153.44l21.15-21.15c3.12-3.12 3.12-8.19 0-11.31l-22.63-22.63c-3.12-3.12-8.19-3.12-11.31 0L160 222.06 36.29 98.34c-3.12-3.12-8.19-3.12-11.31 0L2.34 120.97c-3.12 3.12-3.12 8.19 0 11.31L126.06 256 2.34 379.71c-3.12 3.12-3.12 8.19 0 11.31l22.63 22.63c3.12 3.12 8.19 3.12 11.31 0L160 289.94 262.56 392.5l21.15 21.15c3.12 3.12 8.19 3.12 11.31 0l22.63-22.63c3.12-3.12 3.12-8.19 0-11.31L193.94 256z" class=""></path></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</nav> -->

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@microsoft/microsoft-graph-client/lib/graph-js-sdk.js"></script>
<!-- polyfilling promise -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/es6-promise/dist/es6-promise.auto.min.js"></script>

<!-- polyfilling fetch -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/whatwg-fetch/dist/fetch.umd.min.js"></script>

<!-- depending on your browser you might wanna include babel polyfill -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@babel/polyfill@7.4.4/dist/polyfill.min.js"></script>



<script>
  
    $( document ).ready(function() {
        auth_request();
    });

    function auth_request(){
        var formData = new FormData();

        formData.append("startDateTime", "2020-07-02T13:00:34.2444915-07:00");
        formData.append("endDateTime", "2020-07-12T15:00:34.2464912-07:00");
        formData.append("subject", "Test");

        var xhr = new XMLHttpRequest();
        xhr.open('POST', "https://graph.microsoft.com/v1.0/me/onlineMeetings", true);
        xhr.send(formData);

        xhr.onreadystatechange = processRequest;

        function processRequest(e) {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                console.log(response);
            }
        }
    }
    
    function authenticate_MS_Teams_and_start_meeting(){
        // Configuration options for MSAL @see https://github.com/AzureAD/microsoft-authentication-library-for-js/wiki/MSAL.js-1.0.0-api-release#configuration-options
        var msalConfig = {
            auth: {
                clientId: "21c4992b-b952-4831-95dc-80bf6de57d08", // Client Id of the registered application
                redirectUri: "https://skillcentral.ng",
            },
        };

        console.log('msalConfig - ' + msalConfig);

        var graphScopes = ["user.read", "mail.send"]; // An array of graph scopes

        console.log('graphScopes - ' + graphScopes);

        // Important Note: This library implements loginPopup and acquireTokenPopup flow, remember this while initializing the msal
        // Initialize the MSAL @see https://github.com/AzureAD/microsoft-authentication-library-for-js#1-instantiate-the-useragentapplication
        var msalApplication = new Msal.UserAgentApplication(msalConfig);
        console.log('msalApplication - ' + msalApplication);

        var options = new MicrosoftGraph.MSALAuthenticationProviderOptions(graphScopes);
        console.log('options - ' + options);

        var authProvider = new MicrosoftGraph.ImplicitMSALAuthenticationProvider(msalApplication, options);
        console.log('authProvider - ' + authProvider);

        init_meeting(authProvider);
    }

    function init_meeting(authProvider){       
        var options = {
            authProvider,
        };

        console.log('init_meeting options - ' + options);

        var client = Client.init(options);
        console.log('init_meeting client - ' + client);

        var onlineMeeting = {
            startDateTime:"2019-07-12T14:30:34.2444915-07:00",
            endDateTime:"2019-07-12T15:00:34.2464912-07:00",
            subject:"User Token Meeting"
        };
        console.log('init_meeting onlineMeeting - ' + onlineMeeting);

      //  var res = await client.api('/me/onlineMeetings')
        //    .post(onlineMeeting);

            online_meeting_api(onlineMeeting);

        console.log(res);

    }
   

  
</script>
</body>
</html>
