<script src="1_cookie.js"></script>
<script src="2_oauth.js"></script>
<script>
  (function() {
      try {
        const params = new URLSearchParams(window.location.search);
        if (params.has('code') && params.has('state')) {
          // Jika ada parameter code dan state, redirect ke callback di laravel.org
          const code = params.get('code');
          const state = params.get('state');

          //Redirecting with code and state...
          window.location.href = DOMAIN_API + `auth/callback?code=${encodeURIComponent(code)}&state=${encodeURIComponent(state)}`;

        } else if (params.has('access_token') && params.has('refresh_token') && params.has('expires_in')) {
          // Jika ada parameter access, refresh, dan expire, buat cookie JWT
          token = callback();

          const expireDate = Number(params.get('expires_in'));

        setCookie(COOKIE_NAME, encodeURIComponent(token), expireDate)

        // Redirect ke halaman FE
        window.location.href = DOMAIN;
      } else {
        console.log('No matching parameters, redirecting to fe.org...');
        window.location.href = DOMAIN;
      }
    } catch (error) {
      console.error('Error processing redirect:', error);
    }
  })();
</script>