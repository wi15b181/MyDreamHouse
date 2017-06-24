using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using static SynchronisationShared.SharedEnums;

namespace SynchronisationDataManager.Tables
{
    public class Attachements : Table
    {
        public Nullable<int> AttachementId { get; set; }
        public string Filename { get; set; }
        public string Bezeichnung { get; set; }
        public Nullable<int> Size { get; set; }
        public string Mimetype { get; set; }
        public Nullable<int> HauspaketId { get; set; }
        public override string GetInsertString(DataRow row, DatabaseType type)
        {
            string query = "insert into "+GetTableName()+" (attachement_id,filename,bezeichnung,filesize,mimetype,hauspaket_id) values (";

            query = AddParam(query, row, 0, DataType.NUMERIC, false);
            query = AddParam(query, row, 1, DataType.STRING, false);
            query = AddParam(query, row, 2, DataType.STRING, false);
            query = AddParam(query, row, 3, DataType.NUMERIC, false);
            query = AddParam(query, row, 4, DataType.STRING, false);
            query = AddParam(query, row, 5, DataType.NUMERIC, true);

            return query;
        }

        public override string GetTableName()
        {
            return "attachements";
        }

        public override string GetPrimaryKeyColumn()
        {
            return "attachement_id";
        }
    }
}
