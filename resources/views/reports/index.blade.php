
    <head>
        <title>Bootstrap Example</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">



    </head>
    <body>
    <div class="col-12">
        <div class="card">
            <div class="container my-3">

                <div class="card">
                    <div class="card-header">

                        <div class="d-flex">
                            <div class="title">
                                <h3>Responsive Tabs</h3>
                                <p class="mb-4">Created with &#x1F9E1; by <a href="https://elmah.io/?utm_source=codepen&utm_medium=social&utm_campaign=codepen" target="_blank">elmah.io</a> team.</p>
                            </div>
                            <div class="ml-auto">
                                <a class="text-dark" href="https://elmah.io/?utm_source=codepen&utm_medium=social&utm_campaign=codepen" target="_blank">
                                    <div class="elmahio-ad d-flex">
                                        <div class="logo"><img src="https://elmah.io/images/logo.png" /></div>
                                        <div class="motto d-none d-sm-block px-2">Would your users appreciate fewer errors?</div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <!-- START TABS DIV -->
                        <div class="tabbable-responsive">
                            <div class="tabbable">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="first-tab" data-toggle="tab" href="#first" role="tab" aria-controls="first" aria-selected="true">First Tab</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="second-tab" data-toggle="tab" href="#second" role="tab" aria-controls="second" aria-selected="false">Second Tab</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="third-tab" data-toggle="tab" href="#third" role="tab" aria-controls="third" aria-selected="false">Third Tab</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="fourth-tab" data-toggle="tab" href="#fourth" role="tab" aria-controls="fourth" aria-selected="false">Fourth Tab</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="fifth-tab" data-toggle="tab" href="#fifth" role="tab" aria-controls="fifth" aria-selected="false">Fifth Tab</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="sixth-tab" data-toggle="tab" href="#sixth" role="tab" aria-controls="sixth" aria-selected="false">Sixth Tab</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="first" role="tabpanel" aria-labelledby="first-tab">
                                <h5 class="card-title">First Tab header</h5>
                                <p class="card-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                            </div>
                            <div class="tab-pane fade" id="second" role="tabpanel" aria-labelledby="second-tab">
                                <h5 class="card-title">Second Tab header</h5>
                                <p class="card-text">In hac habitasse platea dictumst. Cras sit amet massa fermentum risus eleifend malesuada vel nec erat. Cras massa tellus, volutpat efficitur feugiat eu, accumsan vel felis. Nullam ornare tellus eu dolor rhoncus, ut tempor lectus tincidunt. Ut in condimentum lectus. Praesent non pretium mauris, efficitur condimentum ex. Nam ante lorem, eleifend in egestas a, rhoncus at ex.</p>
                            </div>
                            <div class="tab-pane fade" id="third" role="tabpanel" aria-labelledby="third-tab">
                                <h5 class="card-title">Third Tab header</h5>
                                <p class="card-text">Vestibulum neque nunc, ullamcorper et laoreet in, dictum vitae nisi. Morbi scelerisque cursus lobortis. Fusce a leo elit. In hac habitasse platea dictumst. Curabitur aliquet nunc sed tellus rutrum ornare. Mauris euismod cursus ligula, nec mollis lorem sodales vel. Proin mollis posuere nisl a pretium. Aenean sit amet nibh quis nisl pharetra malesuada convallis id leo.</p>
                            </div>
                            <div class="tab-pane fade" id="fourth" role="tabpanel" aria-labelledby="fourth-tab">
                                <h5 class="card-title">Fourth Tab header</h5>
                                <p class="card-text">Nulla dignissim justo sed nulla dignissim pellentesque. Maecenas rhoncus faucibus finibus. Mauris eget tincidunt metus. Morbi bibendum nunc sed nisl aliquam, sit amet lacinia lectus pharetra. Cras accumsan convallis risus. Morbi nisi libero, consequat eget leo vel, finibus rhoncus nulla. Mauris tempus risus quis efficitur sollicitudin. Suspendisse potenti. Quisque ut leo interdum ipsum tristique ultrices.</p>
                            </div>
                            <div class="tab-pane fade" id="fifth" role="tabpanel" aria-labelledby="fifth-tab">
                                <h5 class="card-title">Fifth Tab header</h5>
                                <p class="card-text">Nunc lacinia sodales ex, in mattis nulla eleifend in. Quisque molestie, dolor non egestas ornare, diam sapien accumsan erat, non malesuada nulla est ac purus. Donec pharetra molestie leo sit amet posuere. Etiam feugiat mi nisi, id semper neque dignissim ut. Praesent vitae accumsan eros. Curabitur a nisi non arcu suscipit rutrum at ut orci. Praesent nec eros eros. Quisque tempus neque ut nibh viverra, ut commodo dolor dapibus.</p>
                            </div>
                            <div class="tab-pane fade" id="sixth" role="tabpanel" aria-labelledby="sixth-tab">
                                <h5 class="card-title">Sixth Tab header</h5>
                                <p class="card-text">Proin ornare purus vitae magna viverra suscipit. Etiam rutrum lorem cursus libero scelerisque lacinia. Praesent bibendum risus id aliquam finibus. Donec sed orci sodales, viverra dolor a, dignissim mi. Pellentesque nec lectus enim. Suspendisse eu ligula ac tortor mollis lobortis. Nulla a laoreet neque, sit amet luctus dolor. Nam facilisis at odio ac commodo. Nullam vehicula blandit dui, vel suscipit orci.</p>
                            </div>
                        </div>
                        <!-- END TABS DIV -->

                    </div>
                    <div class="card-footer p-0">
                        <h5 class="text-center"><small class="text-muted">Bootstrap 4.3.1</small></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>




    </body>


<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.15.0/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>



    <template>
        <admin-layout>
            <div class="">
                <div class="tabbable-responsive">
                    <div class="tabbable">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="first-tab" data-toggle="tab" href="#first" role="tab" aria-controls="first" aria-selected="true">First Tab</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="second-tab" data-toggle="tab" href="#second" role="tab" aria-controls="second" aria-selected="false">Second Tab</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="third-tab" data-toggle="tab" href="#third" role="tab" aria-controls="third" aria-selected="false">Third Tab</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="fourth-tab" data-toggle="tab" href="#fourth" role="tab" aria-controls="fourth" aria-selected="false">Fourth Tab</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="fifth-tab" data-toggle="tab" href="#fifth" role="tab" aria-controls="fifth" aria-selected="false">Fifth Tab</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="sixth-tab" data-toggle="tab" href="#sixth" role="tab" aria-controls="sixth" aria-selected="false">Sixth Tab</a>
                            </li>
                        </ul>

                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="first" role="tabpanel" aria-labelledby="first-tab">
                        <h5 class="card-title">First Tab header</h5>
                        <p class="card-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                    </div>
                    <div class="tab-pane fade" id="second" role="tabpanel" aria-labelledby="second-tab">
                        <h5 class="card-title">Second Tab header</h5>
                        <p class="card-text">In hac habitasse platea dictumst. Cras sit amet massa fermentum risus eleifend </p>
                    </div>
                    <div class="tab-pane fade" id="third" role="tabpanel" aria-labelledby="third-tab">
                        <h5 class="card-title">Third Tab header</h5>
                        <p class="card-text">Vestibulum neque nunc, ullamcorper et laoreet in, dictum vitae nisi. Morbi scelerisque</p>
                    </div>
                    <div class="tab-pane fade" id="fourth" role="tabpanel" aria-labelledby="fourth-tab">
                        <h5 class="card-title">Fourth Tab header</h5>
                        <p class="card-text">Nulla dignissim justo sed nulla dignissim pellentesque. Maecenas rhoncus faucibus</p>
                    </div>
                    <div class="tab-pane fade" id="fifth" role="tabpanel" aria-labelledby="fifth-tab">
                        <h5 class="card-title">Fifth Tab header</h5>
                        <p class="card-text">Nunc lacinia sodales ex, in mattis nulla eleifend in. Quisque molestie.</p>
                    </div>
                    <div class="tab-pane fade" id="sixth" role="tabpanel" aria-labelledby="sixth-tab">
                        <h5 class="card-title">Sixth Tab header</h5>
                        <p class="card-text">Proin ornare purus vitae magna viverra suscipit.</p>
                    </div>
                </div>
            </div>
        </admin-layout>
    </template>
    <style>
        .nav-link {
            border-bottom: 1px solid #dee2e6 !important;
        }
        .nav.nav-tabs .nav-item, .nav.nav-pills .nav-item{
            margin-right: 0!important;
        }
        .nav.nav-tabs .nav-item .nav-link, .nav.nav-pills .nav-item .nav-link{
            border-radius: 0!important;
        }
        .nav.nav-tabs .nav-item .nav-link.active, .nav.nav-pills .nav-item .nav-link.active{
            box-shadow: none;
            border-bottom: 0!important;
            border-top: 1px solid #dee2e6 !important;
            border-top: 1px solid #dee2e6 !important;
            border-right: 1px solid #dee2e6 !important;
            border-left: 1px solid #dee2e6 !important;
        }
        .nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link{
            background-color: #FFFFFF!important;
            color: black!important;
        }
    </style>

