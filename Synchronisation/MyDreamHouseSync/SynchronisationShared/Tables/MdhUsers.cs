using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using static SynchronisationShared.SharedEnums;

namespace SynchronisationDataManager.Tables
{
    public class MdhUsers : Table
    {
        public override string GetInsertString(DataRow row, DatabaseType type)
        {
            string query = "insert into " + GetTableName() + " (id,name,username,email,password) values (";

            query = AddParam(query, row, 0, DataType.NUMERIC, false);
            query = AddParam(query, row, 1, DataType.STRING, false);
            query = AddParam(query, row, 2, DataType.STRING, false);
            query = AddParam(query, row, 3, DataType.STRING, false);
            query = AddParam(query, row, 4, DataType.STRING, true);

            return query;
        }

        public override string GetPrimaryKeyColumn()
        {
            return "id";
        }

        public override string GetTableName()
        {
            return "mdh_users";
        }
    }
}
