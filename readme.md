# Gambit challenge

## Summary

Here is solution for the Gambit test task. It's original text is located below.

This project runs on laravel 5.5 on the backend and vue.js 2.5 on the frontend.

Live demo is available at: http://gambit.pellinen.ru/

## Installation

```
git clone git@github.com:igronus/gambit.git
cd gambit
composer install
chown -R www-data:www-data storage
cp .env.example .env
php artisan cache:clear
php artisan key:generate
```

After that set up web-server to serve laravel or just run `php artisan serve`.

### Devices emulation  

If you want to emulate devices, generate serialized array like this:

```
$devices = [
    'DEVICE1' => 'http://your-domain.ru/emulate?device1',
    'DEVICE2' => 'http://your-domain.ru/emulate?device2',
];
serialize($devices);
```

And put it into your .env file:

```
DEVICES='a:2:{s:7:"DEVICE1";s:37:"http://your-domain.ru/emulate?device1";s:7:"DEVICE2";s:37:"http://your-domain.ru/emulate?device2";}'
```

Command `php artisan config:cache` may need to be executed to clear application configuration cache.

NB: internal `php artisan serve` won't work while accessing `http://127.0.0.1:8000/emulate` by `file_get_contents()` function. So use real web server in this case.

### Downloader cache

If you want to increase/decrease number of requests to data feeds tune up downloader cache params in your .env file:

```
DOWNLOADER_CACHE=true
DOWNLOADER_CACHE_TIMEOUT=5
```

### Frontend developing

Run `npm ci` to install dependencies and `npm run dev` to build public/js/app.js.

If it doesn't work, check you have latest stable npm and node installed and do the following:

```
rm -rf node_modules package-lock.json
npm cache clear --force
npm install
```

## Task

<details>
    <summary>TL;DR</summary>
 
    ### Problem description
    
    TUF-2000M is an ultrasonic energy meter that has a [Modbus](https://en.wikipedia.org/wiki/Modbus) interface described in docs/tuf-2000m.pdf.
    
    Gambit has access to one of these meters and it is providing you a [live text feed](http://tuftuf.gambitlabs.fi/feed.txt) that shows the time of the reading followed by the first 100 register values which look like this:
    
    ```
    2017-01-11 19:12
    1:7579
    2:48988
    3:5064
    4:48142
    5:37967
    6:48877
    7:63814
    8:17575
    9:0
    10:0
    11:24224
    12:15965
    13:0
    14:0
    15:0
    16:0
    17:87
    18:0
    19:9891
    20:16221
    21:65480
    22:65535
    23:39041
    24:48994
    25:0
    26:0
    27:0
    28:0
    29:144
    30:0
    31:48777
    32:16191
    33:15568
    34:16611
    35:28424
    36:16534
    37:7424
    38:15783
    39:14592
    40:15758
    41:5461
    42:49087
    43:45184
    44:15493
    45:36608
    46:15459
    47:29184
    48:15516
    49:0
    50:0
    51:0
    52:0
    53:6432
    54:4386
    55:5889
    56:0
    57:0
    58:0
    59:0
    60:255
    61:120
    62:0
    63:0
    64:0
    65:0
    66:4001
    67:62500
    68:0
    69:0
    70:3
    71:4
    72:4
    73:3606
    74:16800
    75:54913
    76:48896
    77:35706
    78:17101
    79:44042
    80:17099
    81:33339
    82:16963
    83:42500
    84:49530
    85:33468
    86:16963
    87:33210
    88:16963
    89:2885
    90:16512
    91:0
    92:806
    93:3501
    94:3501
    95:0
    96:1
    97:43137
    98:17105
    99:3374
    100:17839
    ```
    
    To help you on your way with data conversion I will give you a few clues based on the example data above:
    
    - Register 21-22, Negative energy accumulator is -56.
    - Register 33-34, Temperature #1/inlet is 7.101173400878906.
    - Register 92, Signal Quality is 38.
    
    The registers and their respective datatypes are explained in detail in [docs/tuf-2000m.pdf](https://github.com/gambit-labs/tuf-2000m/blob/master/docs/tuf-2000m.pdf) on pages 39-42.
    
    ### Your task
    
    #### Option 1: Parsing the Modbus data
    
    Create a program that parses the data, converts it to human readable data like integers, decimals and strings and presents it in a nice way. Depending on your skills and interests you can create a web service that will provide the conversion data, or you could even create a UI to visualize the data somehow, it is entirely up to you what you make of it!
    
    #### Option 2: Web or native app 
    
    If the data conversion path in option 1 is not something that interests you, or you prefer a more graphical solution, create an app that retrieves and parses the data and presents it as is. The key point is to make use of data available in a backend, and present it in a mobile friendly way.
    
    ### Presenting your solution
    
    Provide your solution as a Git repository, e-mail me the link to your private repo, or as a zip file and describe your solution either in the mail or using the README markdown. We appreciate if you can host your solution somewhere in the cloud so we can see an actual demo of it, rather than just looking at code.
    
    There is no single solution to this problem, and we don't expect a complete solution to consider you for a position. Good use of Git version control is appreciated.
</details>

## Architecture

You can see a sketch below.

![architecture_sketch](https://github.com/igronus/gambit/blob/master/doc/architecture_sketch.jpg)

The main thing is backend module. It is responsible for getting data from text feeds (or in other format in the future), caching it for some time (to avoid unnecessary requests), storing it if needed and serving clients.

Let's describe how it should process, step by step.

```
1. Client 1 makes a request to a backend to get data.
2. Backend checks that there is no actual data in cache and gets it from feed.
3. Backend caches data in case of other clients requests.
4. Backend makes a response to Client 1 due to it's permissions.
5. Client 2 makes a request to a backend to get data.
6. Backend checks that there is actual data in cache and makes a response 
    to Client 2 due to it's permissions.
7. Client 3 makes a request to a backend to get data.
8. Backend checks that there is actual data in cache and makes a response 
    to Client 3 due to it's permissions.
```
