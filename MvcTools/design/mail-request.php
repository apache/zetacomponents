Return-path: <SRS0=DbNu=XN=ez.no=ts@php.net>
Envelope-to: derick@localhost
Delivery-date: Tue, 01 Jul 2008 11:28:53 +0200
Received: from localhost
    ([127.0.0.1] helo=kossu.ez.no ident=derick)
    by kossu.ez.no with esmtp (Exim 4.69)
    (envelope-from <SRS0=DbNu=XN=ez.no=ts@php.net>)
    id 1KDcAP-0002Fl-Sj
    for derick@localhost; Tue, 01 Jul 2008 11:28:53 +0200
X-Spam-Tests: none
X-Spam-Score: 0.0 required=8.0
X-Spam-Flag: NO
X-Spam-Checker-Version: SpamAssassin 3.2.5 (2008-06-10) on jdi.jdi-ict.nl
X-Spam-Level: 
X-Spam-Status: No, score=0.0 required=8.0 tests=none autolearn=disabled
    version=3.2.5
X-Spam-Summary: _SUMMARY_
X-Spam-Report: 
Received: from 127.0.0.1 [127.0.0.1]
    by kossu.ez.no with POP3 (fetchmail-6.3.8)
    for <derick@localhost> (single-drop); Tue, 01 Jul 2008 11:28:53 +0200 (CEST)
Received: from localhost (localhost [127.0.0.1])
    by mail.jdi-ict.nl (8.13.7/8.12.11) with ESMTP id m619QaAb032244
    for <derick@[127.0.0.1]>; Tue, 1 Jul 2008 11:26:36 +0200
X-Virus-Scanned: by amavisd-new at jdi-ict.nl
Received: from osu1.php.net (osu1.php.net [140.211.166.39])
    by jdi.jdi-ict.nl (8.13.7/8.12.11) with ESMTP id m619QZD6032231
    for <php@derickrethans.nl>; Tue, 1 Jul 2008 11:26:35 +0200
Authentication-Results: osu1.php.net header.from=ts@ez.no; sender-id=neutral
Authentication-Results: osu1.php.net smtp.mail=ts@ez.no; spf=neutral; sender-id=neutral
Received: from [140.211.166.133] ([140.211.166.133:34840] helo=hemlock.osuosl.org)
    by osu1.php.net (envelope-from <ts@ez.no>)
    (ecelerity 2.2.2.32 r(25190M)) with ESMTP
    id 45/A2-05202-2C9F9684; Tue, 01 Jul 2008 02:32:50 -0700
Received: from localhost (localhost [127.0.0.1])
    by hemlock.osuosl.org (Postfix) with ESMTP id 5DCFEA46B5
    for <derick@php.net>; Tue,  1 Jul 2008 09:26:28 +0000 (UTC)
X-Virus-Scanned: amavisd-new at osuosl.org
Received: from hemlock.osuosl.org ([127.0.0.1])
    by localhost (.osuosl.org [127.0.0.1]) (amavisd-new, port 10024)
    with ESMTP id P3Z+2bhniu-t for <derick@php.net>;
    Tue,  1 Jul 2008 09:26:26 +0000 (UTC)
X-Greylist: IP, sender and recipient auto-whitelisted, not delayed by milter-greylist-3.0 (jdi.jdi-ict.nl [82.94.239.7]); Tue, 01 Jul 2008 11:26:36 +0200 (CEST)
X-Greylist: domain auto-whitelisted by SQLgrey-1.7.4
Received: from mta1.ez.no (mta1.ez.no [85.19.74.84])
    by hemlock.osuosl.org (Postfix) with ESMTP id 40530A46B2
    for <derick@php.net>; Tue,  1 Jul 2008 09:26:26 +0000 (UTC)
Received: from smtp.ez.no (blackboy.ez.no [194.248.150.22])
    by mta1.ez.no (Postfix) with ESMTP id 72B694A061B
    for <dr@ez.no>; Tue,  1 Jul 2008 11:25:18 +0200 (CEST)
Received: from [129.217.155.133] (vpn1133.hrz.uni-dortmund.de [129.217.155.133])
    by smtp.ez.no (Postfix) with ESMTP id 72581AB558;
    Tue,  1 Jul 2008 11:18:30 +0200 (CEST)
Message-ID: <4869F84F.2060803@ez.no>
Date: Tue, 01 Jul 2008 11:26:39 +0200
From: Tobias Schlitt <ts@ez.no>
Organization: eZ Systems AS
User-Agent: Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.7.5) Gecko/20041124 Thunderbird/0.9 Mnenhy/0.6.0.104
MIME-Version: 1.0
To: Derick Rethans <dr@ez.no>
Cc: Components <components@lists.ez.no>
Subject: Re: [Components] [Sdk-public] MmvTools requirements and design
References: <alpine.DEB.0.98.0806251707220.16594@kossu.ez.no> <48678AF4.7010908@ez.no> <alpine.DEB.0.98.0806300846100.16594@kossu.ez.no> <4868A272.2080800@ez.no>
    <alpine.DEB.0.98.0806301153050.16594@kossu.ez.no> <4868DFE3.5090001@ez.no> <alpine.DEB.0.98.0807011003550.16594@kossu.ez.no>
In-Reply-To: <alpine.DEB.0.98.0807011003550.16594@kossu.ez.no>
X-Enigmail-Version: 0.95.6
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
X-Bogosity: No, tests=bogofilter, spamicity=0.000000, version=1.1.7

Ze body

<?php
$req = new ezcMvcRequest();

$req->date = new DateTime( "Tue, 01 Jul 2008 11:26:39 +0200" );
$req->protocol = 'mail';
$req->host = 'ez.no'; // domain part of the To address
$req->uri = 'dr'; // user part of the To address
$req->requestId = 'ez.no/dr'; // combination of above
// The in-reply to value, or the top-most References value.
$req->referrer = 'kossu.ez.no/alpine.DEB.0.98.0807011003550.16594';

// Variables will only be filled in with request filters
$req->variables = array();
$req->body = "Ze body\n";
$req->files = array(); // will come from attachments, the ezcFilePart thingies

$req->accept = new ezcMvcRequestAccept;
$req->accept->types = array();
$req->accept->charsets = array( 'UTF-8' );
$req->accept->languages = array();
$req->accept->encodings = array( '8bit' );

$req->agent = new ezcMvcRequestUserAgent;
$req->agent->agent = 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.7.5) Gecko/20041124 Thunderbird/0.9 Mnenhy/0.6.0.104';

// also comes from filters, or GPG
$req->authentication = new ezcMvcRequestAuthentication; 

$req->raw = new ezcMvcMailRawRequest();
$req->raw->mail = $parsedMail;
?>
