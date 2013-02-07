# -*- encoding: utf-8 -*-
lib = File.expand_path('../lib', __FILE__)
$LOAD_PATH.unshift(lib) unless $LOAD_PATH.include?(lib)
require 'carmalinksdk/version'

Gem::Specification.new do |gem|
  gem.name          = "carmalinksdk"
  gem.version       = CarmaLinkSDK::VERSION
  gem.authors       = ["Christopher Najewicz"]
  gem.email         = ["chris.najewicz@carmasys.com"]
  gem.description   = "Wrapper for using the CarmaLink API"
  gem.summary       = ""
  gem.homepage      = "https://github.com/CarmaSys/CarmaLinkSDK"

  gem.files         = `git ls-files`.split($/)
  gem.executables   = gem.files.grep(%r{^bin/}).map{ |f| File.basename(f) }
  gem.test_files    = gem.files.grep(%r{^(test|spec|features)/})
  gem.require_paths = ["lib"]
end
