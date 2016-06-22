<?php

namespace Multiple\Frontend\Controllers;

class ErrorController extends ControllerBase
{

    public function show404Action()
    {
        $this->response->setStatusCode(404, "Not Found");
        echo("<html>
                <head>
                    <title>Error 404 - Page Not Found</title>
                </head>
                <body>
                    <center style='margin-top: 5%; padding: 10px;'>
                        <img src='/backend/images/dead-bird-hi.png' alt='Error 404 - Page Not Found'>
                        <h1 style='color: teal'>ERROR 404</h1>
                        <p style='color: #7f8c8d'>You have tried to access a page which does not exist or has been moved.</p>
                    </center>
                </body>
            </html>");
    }

    public function show503Action()
    {
        $this->response->setStatusCode(503, "Service Unavailable");
        echo("<html>
                <head>
                    <title>Error 503 - Service Unavailable</title>
                </head>
                <body>
                    <center style='margin-top: 5%; padding: 10px;'>
                        <img src='/backend/images/dead-bird-hi.png' alt='Error 404 - Page Not Found'>
                        <h1 style='color: teal'>ERROR 503</h1>
                        <p style='color: #7f8c8d'>Service Unavailable.</p>
                    </center>
                </body>
            </html>");
    }
}