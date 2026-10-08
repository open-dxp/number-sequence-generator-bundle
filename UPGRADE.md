# Upgrade Notes

## 1.1.0
- [BUGFIX] The installer marked an installation with the old name of the bundle from before OpenDXP. The bundle then counted as not installed. A migration marks it with the current name
- [CHORE] Replace Codeception with Pest and `open-dxp/test-foundation`
- [CHORE] Require `open-dxp/opendxp` ^1.5
