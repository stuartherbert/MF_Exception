MF_Exception
=============

**MF_Exception** is a component that provides a generic enterprise-class set of exceptions for use both in the Methodosity Framework and in your own projects.

Installation
------------

You can install MF_Exception in two ways:

Via pear:

    stuart@ubuntu:~$ sudo pear channel-discover pear.methodosity.com 
    Adding Channel "pear.methodosity.com" succeeded
    Discovery of channel "pear.methodosity.com" succeeded

    stuart@ubuntu:~$ sudo pear install MF/MF_Exception
    downloading MF_Exception-0.0.3.tgz ...
    Starting to download MF_Exception-0.0.3.tgz (1,973 bytes)
    ....done: 1,973 bytes
    install ok: channel://pear.methodosity.com/MF_Exception-0.0.3

From source:

    git clone git@github.com:stuartherbert/MF_Exception.git
    cd MF_Exception
    phing install.local

Both of these approaches will install the MF_Exception code into your system's standard location (usually /usr/share/php).

Usage
-----

First include the autoloader:

    <?php

    define('APP_TOPDIR', path/to/your/webapp);

    // optional - APP_LIBDIR
    define('APP_LIBDIR', APP_TOPDIR . '/libraries');

    require_once 'mf.autoloader.php';

    ?>

APP_TOPDIR must point to the root folder of your webapp. APP_LIBDIR is optional (mf.autoloader.php will define it for you if necessary).

After that, you can create your own exceptions by inheriting from the
following classes:

* MF\Exception\InternalFaultException is the base class to use in generic
  packages.

* MF\Exception\ProcessException is the base class to use in your apps

See the full documentation for more details.

Development
-----------

You will need the following dependencies installed first.

* Phing
* d51PearPkg2Task plugin for Phing from domain51.com
* PHPUnit
* xdebug
* pdepend
* phpDocumentor
* phpmd
* phpcpd
* phpcs
* phpcb

This component includes a build.xml file containing several options to make life a little easier.

    stuart@ubuntu:~/MF/MF_Autoloader$ phing
    Buildfile: /home/stuart/MF/MF_Autoloader/build.xml

    MF_Autoloader > help:

         [echo] MF_Autoloader 0.0.3: build.xml targets:
         [echo] 
         [echo] test
         [echo]   Run the component's PHPUnit tests
         [echo] code-review
         [echo]   Run code quality tests (pdepend, phpmd, phpcpd, phpcs)
         [echo] pear-package
         [echo]   Create a PEAR-compatible package
         [echo] install.local
         [echo]   Install this component from source
         [echo]   You must be root to run this target!!
         [echo] publish
         [echo]   Publish the pear package onto the channel server
         [echo] clean
         [echo]   Remove all temporary folders created by this build file

    BUILD FINISHED

    Total time: 0.2625 seconds

License
-------

**This component is released under the new-style BSD license.**

Copyright (c) 2010, Stuart Herbert
All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

* Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
* Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
* Neither the name of the copyright holder nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
