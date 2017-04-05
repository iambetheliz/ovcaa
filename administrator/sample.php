<style type="text/css">
 body {
    font-family: sans-serif;
    background: #333;
    color: #eee;
}

a {
    text-decoration: none;
    color: hsl(206, 80%, 50%);
}

.roll {
    display: inline-block;
    overflow: hidden;

    vertical-align: top;

    -webkit-perspective: 400px;
       -moz-perspective: 400px;

    -webkit-perspective-origin: 50% 50%;
       -moz-perspective-origin: 50% 50%;
}
.roll span {
    display: block;
    position: relative;
    padding: 0 2px;

    -webkit-transition: all 400ms ease;
       -moz-transition: all 400ms ease;
    
    -webkit-transform-origin: 50% 0%;
       -moz-transform-origin: 50% 0%;
    
    -webkit-transform-style: preserve-3d;
       -moz-transform-style: preserve-3d;
}
    .roll:hover span {
        background: #111;

        -webkit-transform: translate3d( 0px, 0px, -30px ) rotateX( 90deg );
           -moz-transform: translate3d( 0px, 0px, -30px ) rotateX( 90deg );
    }
.roll span:after {
    content: attr(data-title);

    display: block;
    position: absolute;
    left: 0;
    top: 0;
    padding: 0 2px;

    color: #fff;
    background: hsl(206, 80%, 30%);

    -webkit-transform-origin: 50% 0%;
       -moz-transform-origin: 50% 0%;

    -webkit-transform: translate3d( 0px, 105%, 0px ) rotateX( -90deg );
       -moz-transform: translate3d( 0px, 105%, 0px ) rotateX( -90deg );
} 

  
</style>
<script type="text/javascript">
  var supports3DTransforms =  document.body.style['webkitPerspective'] !== undefined || 
                            document.body.style['MozPerspective'] !== undefined;

function linkify( selector ) {
    if( supports3DTransforms ) {
        
        var nodes = document.querySelectorAll( selector );

        for( var i = 0, len = nodes.length; i < len; i++ ) {
            var node = nodes[i];

            if( !node.className || !node.className.match( /roll/g ) ) {
                node.className += ' roll';
                node.innerHTML = '<span data-title="'+ node.text +'">' + node.innerHTML + '</span>';
            }
        };
    }
}

linkify( 'a' );
</script>
<h1>
    <a href="http://slipsum.com/">Samuel L Ipsum</a>
</h1>

<p>Wanted to spice up the links around <a href="http://hakim.se">my site</a> and ended up re-creating this over-the-top Flash classic.</p>

<p>Do you see any <a href="http://pbskids.org/teletubbies/">Teletubbies</a> in here? Do you see a slender <a href="http://en.wikipedia.org/wiki/Plastic">plastic</a> tag clipped to my shirt with my name printed on it? Do you see a little Asian child with a blank expression on his face sitting outside on a <a href="http://en.wikipedia.org/wiki/Helicopter">mechanical helicopter</a>that shakes when you put quarters in it? No? Well, that's what you see at a toy store. And you must think you're in a toy store, because you're here shopping for an infant named Jeb.</p>

<p>Well, the way they make shows is, they make one show. That show's called a <a href="http://en.wikipedia.org/wiki/Television_pilot">pilot</a>. Then they show that show to the people who make shows, and on the strength of that one show they decide if they're going to make more shows. Some pilots get picked and become <a href="http://en.wikipedia.org/wiki/Television_program">television programs</a>. Some don't, become nothing. She starred in one of the ones that became nothing.</p>
