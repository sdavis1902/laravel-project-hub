# Laravel Project Hub

I needed a system to track my projects and tasks I was working on.  I didn't need anything complex, just basic info, comments, status, attachments and not much more.  I also wanted a Kanban board.  I couldn't find anything that I liked, they where all either bloated, or expensive.  So, I decided to just build my own.

It's using Laravel, as the title indicates, so you set it up like you would any Laravel site.

Since I am the only one using it, there are some features I've yet to build because I haven't needed them.  User management for instance.  When you first log in, if there are no users, then it creates one with the username and password you used.  So you don't have to manually create them in the DB.  But there is currently no UI for adding additional users.  It would not take long to do, but I've had no need of it, so haven't bothered.  If someone want's to use this and needs this, you can build it yourself, or let me know and I'll try to find some time.

It supports webhooks for both github and bitbucket.  You just create the webhooks and point it to http://yoururl.com/hook/bitbucket or http://yoururl.com/hook/github.  Then just inculde sdh-101 ( replacing 101 with the id of your task ) in your commit message and it will link them.  It is currently hard coded to sdh-##, but this could easlily be changed to pull from an environment file.  I'll probably do that in the future.

You may notice that the views are all using twig rather than blade.  I'm using https://github.com/rcrowe/TwigBridge .  Why?  I like Twig.

As I said, it's a bit incomplete in a few areas, but meets all my needs.  If someone else actually wants to use this and needs some of these things completed, feel free to do it yourself, or let me know and I'll try to find some time to do so.

## Contributing

If you want to contribute, submit a pull request and I'll have a look at it

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
