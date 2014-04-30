jsToPhpCompression
==================

LZW Compression adapted from RosettaCode

This small script allows you to compress strings in javascript, send it to php, and decompress it in php.  It works most of the time currently.  Any thoughts or suggestions are appreciated.



JS:


LZW.compress(yourString);
LZW.decompress(yourCompressedString);


PHP:

lzw_decompress(yourCompressedString);
lzw_compress(yourString);

