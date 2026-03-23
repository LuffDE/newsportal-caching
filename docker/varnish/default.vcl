vcl 4.1;

# Backend für React-Frontend
backend frontend {
    .host = "frontend";
    .port = "3000";
}

# Backend für Symfony-API
backend api {
    .host = "app";
    .port = "80";
}

sub vcl_recv {
    # API-Endpunkte an "app" weiterleiten
    if (req.url ~ "^/api") {
        set req.backend_hint = api;

        # Nur GET-Requests cachen
        if (req.method != "GET") {
            return (pass);
        }

        return (hash);
    }

    # Alles andere geht ans React-Frontend
    set req.backend_hint = frontend;
    return (hash);
}

sub vcl_backend_response {
    if (bereq.backend == api) {
        # API-Responses cachen, wenn kein Cache-Control Header gesetzt ist
        if (!(beresp.http.Cache-Control)) {
            set beresp.ttl = 120s;
        }
    } else {
        # Frontend Assets länger cachen
        if (bereq.url ~ "\.(js|css|png|jpg|jpeg|gif|svg|ico)$") {
            set beresp.ttl = 24h;
        } else {
            set beresp.ttl = 30s;
        }
    }
}