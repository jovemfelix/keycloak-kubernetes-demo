# Este projeto demonstra o uso do RH-SSO com uma aplicação frontend acessando backend;

  Versões usadas:
* Openshift: `4.12.x`
* Red Hat Single Sign-On (RHSSO): `7.6`
* Frontend (PHP-Apache): `7.0 - Apache/2.4.25`
* Backend (Node): `9.11.2`

  Veja a seguir nas seções de acordo com o seu foco **DEV** ou **OPS**. 
  
> Nesta demo não será instalado o RHSSO será apenas usado um configuração existente no cluster.
* Foi usado o Operator do RHSSO a instaciado conforme arquivo [Keycloak.yaml](keycloak/sso.yaml)


## DEV

* Veja como construir na pasta de cada projeto:
* [Frontend](frontend/README.md)
* [Backend](backend/README.md)

## OPS

### Variáveis usadas
```shell
RHSSO_NS=rhsso
export RHSSO_HOST=$(oc -n $RHSSO_NS get route/keycloak -o=jsonpath='{.spec.host}')
```

* Para fazer o deploy usando uma imagem existente, seguir os passos a seguir:

### Configuração do Projeto

```shell
# criar um projeto para executar o frontend e backend
$ oc new-project rhsso-openshift-demo
# habilitar permissão de anyuid apenas neste projeto (pois a imagem roda na porta 80)
$ oc adm policy add-scc-to-user anyuid -z default -n 
```

### Implantar o Backend e Frontend
```shell
$ oc create -f k8s/rhsso-config.yml
```

# Referências e Guias

- OpenShift ([guide](https://quarkus.io/guides/deploying-to-openshift)): Generate OpenShift resources from annotations
- Artemis JMS ([guide](https://quarkiverse.github.io/quarkiverse-docs/quarkus-artemis/dev/index.html)): Use JMS APIs to connect to ActiveMQ Artemis via its native protocol
- https://quarkus.io/guides/jms 