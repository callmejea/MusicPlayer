FROM library/php:7.4.26-cli
ENV  LANG="en_US.UTF-8"
MAINTAINER jea <jea@jea.ink>
COPY . /music/
EXPOSE 8888
CMD ["php","-S","0.0.0.0:8888","-t","/music"]