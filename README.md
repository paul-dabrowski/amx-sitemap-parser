# amx-sitemap-parser
The new AMX website is more complex around searching for actual product pages compared to the older trade.amx.com wite. The new site has a complex navigation menu and the search function may not always return useful product results.

This php file will take a sitemap.xml file from amx.com and iterate through all of the Product page URL's to create a new single html file that includes an inline filter function to make searching for groups or individual products easy.

After being run once, a new file AMXindex.html will be saved in the same directory as the php file. This can then be saved locally to your computer or referenced from that point on. 
Be aware that a blank file may need to be created and permissions set to 666 on that file if the directory is not writeable for the www process.

The AMXindex.html file is the sitemap.xml file parsed as of 29 Jan 2019. This sitemap.xml file was manually edited down to exclude non-product pages. The parse script will ignore any URL without 'products' in it.

This has been tested on a Rpi running apache2 server with php7.0 php7.0-curl php7.0-xml required.

The file when testing on the Rpi takes 30 to 40 minutes to go through all links due to running as a single thread and general slowness of the amx.com website.

# Licence
MIT License

Copyright (c) 2019 paul-dabrowski

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.