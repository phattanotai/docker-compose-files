print('Start #################################################################');

db = db.getSiblingDB('nestjs');
db.createUser(
  {
    user: 'admin',
    pwd: '1234',
    roles: [{ role: 'readWrite', db: 'nestjs' }],
  },
);


print('END #################################################################');