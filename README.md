# <a href="https://thiagosena.com" target="_blank">Personal Website</a>

[![Repository Status](https://img.shields.io/badge/Repository%20Status-Maintained-dark%20green.svg)](https://github.com/thiagosena/thiagosena.github.io)
[![Website Status](https://img.shields.io/badge/Website%20Status-Online-green)](https://thiagosena.com)
[![Author](https://img.shields.io/badge/Author-Thiago%20Sena%20-blue.svg)](https://www.linkedin.com/in/thiagodev/)
[![Latest Release](https://img.shields.io/badge/Latest%20Release-17%20February%202024-yellow.svg)](https://github.com/thiagosena/thiagosena.github.io/commit/master)

This website serves as an online portfolio to showcase my web presence, résumé, story. It was generated using using Jekyll, Sass, and Gulp.js.

# Run locally
docker run --name blog --rm  --volume=".:/srv/jekyll"  -p 4000:4000  -it jekyll/jekyll jekyll serve --trace