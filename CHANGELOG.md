# Changelog

All notable changes to `code-distortion/staticall` will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/), and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).



## [0.4.0] - 2025-01-25

### Changed
- Passing values by reference cannot be supported. A `PassByReferenceException` is now thrown when calling a `staticall*` method that expects a parameter to be passed-by-reference

### Added
- Added a `staticallCallWasStatic()` method for `staticall*` methods to use to check if it was called statically or not



## [0.3.0] - 2025-01-07

### Changed
- Removed the `$staticallPrefix` property
- The method prefix is now always `staticall`

### Added
- Added support for PHP 8.4
- Now includes the called class-name in `BadMethodCallException` instead of the top-most parent's
- Added better tests



## [0.2.0] - 2024-03-23

### Changed
- changed the default prefix Staticall uses from `call` to `staticall`
 
See [UPGRADE.md](UPGRADE.md) for info about upgrading



## [0.1.0] - 2023-12-31

### Changed
- Updated package tooling



## [0.0.3] - 2023-11-24

### Added
- Added support for PHP 8.3



## [0.0.2] - 2023-01-17

### Added
- Added support for classes with parents, which might also use Staticall



## [0.0.1] - 2023-01-16

### Added
- Initial release
