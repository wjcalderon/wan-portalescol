#!/bin/sh

BOLD='\033[1m'
MAGENTA='\033[95m'
WARNING='\033[31m⚠️ '
NC='\033[0m' # No Color

run_with_error_handling() {
  if ! $1; then
    echo "\n--------------------------------------------------------------------"
    printf "${WARNING} Error running: $1\n"
    echo "--------------------------------------------------------------------\n"
    exit 1
  fi
}

create_branch() {
  run_with_error_handling "git checkout $2 -q"
  echo "--------------------------------------------------------------------\n"

  git pull origin "$2"

  run_with_error_handling "git checkout -b $1 -q"
  echo "--------------------------------------------------------------------\n"
}

merge_with_base_branch() {
  run_with_error_handling "git checkout $2 -q"
  echo "--------------------------------------------------------------------\n"

  git pull origin "$2"

  run_with_error_handling "git checkout $1 -q"
  echo "--------------------------------------------------------------------\n"

  run_with_error_handling "git merge $2 -m LIB-Prepared-Branch: $2"
  echo "--------------------------------------------------------------------\n"
}

push_merge() {
  run_with_error_handling "git checkout $2 -q"
  echo "--------------------------------------------------------------------\n"

  run_with_error_handling "git merge $1 -m LIB-Prepared-Branch: $2"
  echo "--------------------------------------------------------------------\n"

  run_with_error_handling "git checkout $3 -q"
  echo "--------------------------------------------------------------------\n"

  run_with_error_handling "git pull origin $3"
  echo "--------------------------------------------------------------------\n"

  run_with_error_handling "git checkout $2 -q"
  echo "--------------------------------------------------------------------\n"

  run_with_error_handling "git merge $3 -m LIB-Prepared-Branch: $2"
  echo "--------------------------------------------------------------------\n"

  run_with_error_handling "git push origin $2"
  echo "--------------------------------------------------------------------\n"

  printf "${MAGENTA}Changes pushed from${NC} ${BOLD}$2${NC} ${MAGENTA}to origin${NC}\n"
}

# Checking if the command is being running with a different branch
current_branch=$( git branch --show-current )
if [ "$1" != "$current_branch" ]; then
  printf "${WARNING} The command is being running with a different branch name${NC}\n"
  exit 1
fi

if [ "$2" == "setup" ]; then
  raw_branch_list=$( git branch )

  echo "--------------------------------------------------------------------"
  printf "${BOLD}Reading branches...${NC}\n"
  read -r -a branch_list <<< $raw_branch_list
  printf "${MAGENTA}Done${NC}\n"
  echo "--------------------------------------------------------------------\n"

  master_branch_is_new=true
  develop_branch_is_new=true
  staging_branch_is_new=true

  for element in "${branch_list[@]}"; do

    if [ "$1-master" == "$element" ]; then
      printf "${MAGENTA}Merging $element with master${NC}\\n"
      merge_with_base_branch "$1-master" master
      master_branch_is_new=false
    fi

    if [ "$1-staging" == "$element" ]; then
      printf "${MAGENTA}Merging $element with staging${NC}\n\n"
      merge_with_base_branch "$1-staging" staging
      staging_branch_is_new=false
    fi

    if [ "$1-develop" == "$element" ]; then
      printf "${MAGENTA}Merging $element with develop${NC}\n\n"
      merge_with_base_branch "$1-develop" develop
      develop_branch_is_new=false
    fi
  done

  echo "--------------------------------------------------------------------"

  if [ $master_branch_is_new == true ]; then
    printf "${BOLD}Creating master branch:       $1-master ${NC}\n"
    create_branch "$1-master" master
  fi

  if [ $staging_branch_is_new == true ]; then
    printf "${BOLD}Creating staging branch:          $1-staging ${NC}\n"
    create_branch "$1-staging" staging
  fi

  if [ $develop_branch_is_new == true ]; then
    printf "${BOLD}Creating develop branch:       $1-develop ${NC}\n"
    create_branch "$1-develop" develop
  fi

  printf "${BOLD}Merging/Creating branches finished${NC}\n"
  echo "--------------------------------------------------------------------\n"

  run_with_error_handling "git checkout $1 -q"
fi

if [ "$2" == "push" ]; then

  # Push changes to release, test, develop
  for ELEMENT in 'master' 'staging' 'develop'; do
    push_merge "$1" "$1-${ELEMENT}" ${ELEMENT}
  done

  # Go to original release branch
  run_with_error_handling "git checkout $1 -q"
fi

echo "\n${MAGENTA}--------------------------------------------------------------------"
printf "Done 😎😎\n"
echo "--------------------------------------------------------------------${NC}"
