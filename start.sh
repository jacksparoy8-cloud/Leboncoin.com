#!/bin/bash
cd leboncoin
php -S 0.0.0.0:${PORT:-8000} -t public
