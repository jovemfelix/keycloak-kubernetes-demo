
## Variáveis usadas
```shell
# ajustar para o seu repositório
MY_REPO=quay.io/rfelix
export RHSSO_HOST=$(oc -n $RHSSO_NS get route/keycloak -o=jsonpath='{.spec.host}')
```

## Build da imagem
```shell
$ podman build --no-cache -t ${MY_REPO}/rhsso-ocp-demo-frontend:1.0.0 .
```

## Enviar para o registry
```shell
$ podman login quay.io
$ podman push ${MY_REPO}/rhsso-ocp-demo-frontend:1.0.0
```

## Deploy manual
```shell
$ oc new-app --image=${MY_REPO}/rhsso-ocp-demo-frontend:1.0.0 --name=frontend
```