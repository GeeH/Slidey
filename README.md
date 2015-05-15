# SLIDEY!
## Just Because

Slidey is a generator for creating random slide decks for playing a fun game of slide roulette.

## Installing

- Clone this repository to somewhere local

- Install the php dependencies with `composer update` or something

- Install the front end dependencies in `public` folder by running `npm install`

- In the root dir run `bin/run "<name>"` to generate the slides

- in the `public` folder, use `grunt serve` to serve the slides

Once the `grunt serve` has been used once, generating new slides will automatically update

## Contributing

Contributing slides that can be picked is easy - simply submit a PR with slides in a markdown or html format into the 
relevant directory:

- `title/` for title slides (1 will be selected)
- `content/` for content slides (5 will be selected)
- `finish/` for finishing slides (1 will be selected)

Slides can currently use the `{#NAME!#}` token to have the name entered when generating the slides substituted


> Gary Hockin - May 2015 (gary@hock.in)