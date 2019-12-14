branch_temp=TEMP
branch_main=master
branch_dev=dev
branch_curr=$(git rev-parse --abbrev-ref HEAD)

dir_git=$(git rev-parse --git-dir)
dir_worktrees=_trees
