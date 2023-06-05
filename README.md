# Keycloak Kubernetes Demo

This demo assumes you have minikube installed with the ingress addon enabled.

## Setup URLs

The following URLs uses nip.io to prevent having to modify `/etc/hosts`.

```shell
RHSSO_NS=rhsso
export RHSSO_HOST=$(oc -n $RHSSO_NS get route/keycloak -o=jsonpath='{.spec.host}')
export BACKEND_HOST=backend.$MINIKUBE_IP.nip.io
export FRONTEND_HOST=frontend.$MINIKUBE_IP.nip.io

oc new-project rhsso-openshift-demo
oc adm policy add-scc-to-user anyuid -z default
```
## Keycloak

    kubectl create -f keycloak/keycloak.yaml
    
    cat keycloak/keycloak-ingress.yaml | sed "s/RHSSO_HOST/$RHSSO_HOST/" \
    | kubectl create -f -

    echo https://$RHSSO_HOST

The Keycloak admin console should now be opened in your browser. Ignore the warning caused by the self-signed certificate. Login with admin/admin. Create a new realm and import `keycloak/realm.json`.

The client config for the frontend allows any redirect-uri and web-origin. This is to simplify configuration for the demo. For a production system always use the real URL of the application for the redirect-uri and web-origin.

## Backend
```shell
$ podman build --no-cache -t quay.io/rfelix/rhsso-ocp-demo-backend:1.0.0 backend

$ oc new-app --image=quay.io/rfelix/rhsso-ocp-demo-backend:1.0.0 --name=backend

echo https://$BACKEND_HOST/public
```

## Frontend

```shell
$ podman build --no-cache -t quay.io/rfelix/rhsso-ocp-demo-frontend:1.0.0 frontend

$ oc new-app --image=quay.io/rfelix/rhsso-ocp-demo-frontend:1.0.0 --name=frontend

cat frontend/frontend.yaml | sed "s/RHSSO_HOST/$RHSSO_HOST/" | sed "s/BACKEND_HOST/$BACKEND_HOST/" | \
kubectl create -f -

cat frontend/frontend-ingress.yaml | sed "s/FRONTEND_HOST/$FRONTEND_HOST/" | \
kubectl create -f - 

echo https://$FRONTEND_HOST
```

The frontend application should now be opened in your browser. Login with stian/pass. You should be able to invoke public and invoke secured, but not invoke admin. To be able to invoke admin go back to the Keycloak admin console and add the `admin` role to the user `stian`.
