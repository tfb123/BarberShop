FROM ubuntu

ARG DEBIAN_FRONTEND=noninteractive
ENV T2="Europe/Vilnius"

RUN apt update
RUN apt-get install python3 -y
RUN apt-get install python3-pip -y
RUN apt-get install docker.io software-properties-common -y
RUN add-apt-repository --yes --update ppa:ansible/ansible
RUN apt install ansible -y

RUN pip3 install docker

COPY playbook.yml /opt/playbook.yml

RUN ansible-galaxy collection install community.docker